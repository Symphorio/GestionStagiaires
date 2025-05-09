<?php

namespace App\Http\Controllers;

use Carbon\Carbon; 
use App\Models\Stagiaire;
use App\Models\Tache;
use App\Models\Rapport;
use App\Models\Memoire;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Attestation;

class SuperviseurDashboardController extends Controller
{
    public function index()
    {
        $superviseurId = auth()->guard('superviseur')->id();

        $stats = [
            'stagiaires_count' => Stagiaire::where('superviseur_id', $superviseurId)->count(),
            'taches_count' => Tache::whereHas('stagiaire', function($query) use ($superviseurId) {
                $query->where('superviseur_id', $superviseurId);
            })->where('status', '!=', 'terminé')->count(),
            'rapports_pending_count' => Rapport::whereHas('stagiaire', function($query) use ($superviseurId) {
                $query->where('superviseur_id', $superviseurId);
            })->where('statut', 'en attente')->count(),
            'memoires_pending_count' => Memoire::whereHas('stagiaire', function($query) use ($superviseurId) {
                $query->where('superviseur_id', $superviseurId);
            })->where('statut', 'en attente')->count(),
        ];

        $stagiaires = Stagiaire::where('superviseur_id', $superviseurId)
            ->withCount(['taches as completed_tasks' => function($query) {
                $query->where('statut', 'terminé');
            }])
            ->withCount('taches')
            ->get()
            ->map(function($stagiaire) {
                $stagiaire->progress = $stagiaire->taches_count > 0 
                    ? round(($stagiaire->completed_tasks / $stagiaire->taches_count) * 100, 2)
                    : 0;
                return $stagiaire;
            });

        $taches = Tache::whereHas('stagiaire', function($query) use ($superviseurId) {
                $query->where('superviseur_id', $superviseurId);
            })
            ->with('stagiaire')
            ->latest()
            ->limit(5)
            ->get();

        return view('superviseur.dashboard', compact('stats', 'stagiaires', 'taches'));
    }

    public function stagiaires()
    {
        $superviseurId = auth()->guard('superviseur')->id();
        
        // Seulement les stagiaires avec demandeStage
        $activeStagiaires = Stagiaire::where('superviseur_id', $superviseurId)
            ->where('statut', 'actif')
            ->whereHas('demandeStage')
            ->with(['taches', 'demandeStage'])
            ->withCount([
                'taches as taches_completees' => function($query) {
                    $query->where('statut', 'terminé');
                },
                'taches as taches_total'
            ])
            ->get()
            ->map(function($stagiaire) {
                $now = now();
                $start = Carbon::parse($stagiaire->demandeStage->date_debut);
                $end = Carbon::parse($stagiaire->demandeStage->date_fin);
                
                $totalDays = $start->diffInDays($end);
                $elapsedDays = $now->diffInDays($start);
                
                $stagiaire->progress = $totalDays > 0 
                    ? min(round(($elapsedDays / $totalDays) * 100), 100)
                    : 0;
                    
                return $stagiaire;
            });

        // Stagiaires terminés
        $completedStagiaires = Stagiaire::where('superviseur_id', $superviseurId)
            ->where('statut', 'terminé')
            ->with(['taches', 'demandeStage'])
            ->get()
            ->map(function($stagiaire) {
                $stagiaire->progress = 100;
                return $stagiaire;
            });
    
        // Stagiaires disponibles
        $availableStagiaires = Stagiaire::whereNull('superviseur_id')
            ->where('is_validated', true)
            ->get();
    
        return view('superviseur.stagiaire', [
            'activeStagiaires' => $activeStagiaires,
            'completedStagiaires' => $completedStagiaires,
            'availableStagiaires' => $availableStagiaires
        ]);
    }
    
    public function search(Request $request)
    {
        $term = $request->input('q');
        
        $stagiaires = Stagiaire::where(function($query) use ($term) {
                $query->where('prenom', 'like', "%$term%")
                      ->orWhere('nom', 'like', "%$term%")
                      ->orWhere('email', 'like', "%$term%");
            })
            ->whereNull('superviseur_id')
            ->where('is_validated', true)
            ->get(['id', 'prenom', 'nom', 'email']);
    
        return response()->json($stagiaires);
    }
    
    public function showDetails($id)
    {
        $stagiaire = Stagiaire::with('demandeStage')->findOrFail($id);
        
        // Initialisation des variables
        $dateDebut = null;
        $dateFin = null;
        $dureeRestante = null;
        $specialisation = null;
        $progress = 0;

        if ($stagiaire->demandeStage) {
            $now = now();
            $dateDebut = Carbon::parse($stagiaire->demandeStage->date_debut);
            $dateFin = Carbon::parse($stagiaire->demandeStage->date_fin);
            $specialisation = $stagiaire->demandeStage->specialisation;
            
            $totalDays = $dateDebut->diffInDays($dateFin);
            $elapsedDays = $now->diffInDays($dateDebut);
            $dureeRestante = $dateFin->diffInDays($now);
            
            $progress = $totalDays > 0 
                ? min(round(($elapsedDays / $totalDays) * 100), 100)
                : 0;
        }
    
        // Retourne une vue partielle si c'est une requête AJAX
        if (request()->ajax()) {
            return view('partials.stagiaire-details', [
                'stagiaire' => $stagiaire,
                'progress' => $progress
            ]);
        }
    
        return view('superviseur.stagiaire-details', [
            'stagiaire' => $stagiaire,
            'progress' => $progress,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'dureeRestante' => $dureeRestante,
            'formation' => $specialisation
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stagiaire_id' => 'required|exists:stagiaires,id',
        ]);

        $stagiaire = Stagiaire::findOrFail($request->stagiaire_id);

        if ($stagiaire->superviseur_id) {
            return back()->with('error', 'Ce stagiaire a déjà un superviseur');
        }

        $stagiaire->update([
            'superviseur_id' => auth()->guard('superviseur')->id(),
            'statut' => 'actif',
            'added_manually' => true
        ]);

        return redirect()->route('superviseur.stagiaires')
            ->with('success', 'Stagiaire associé avec succès');
    }

    public function dissociate(Stagiaire $stagiaire)
    {
        if ($stagiaire->superviseur_id !== auth()->guard('superviseur')->id()) {
            abort(403);
        }

        $stagiaire->update([
            'superviseur_id' => null,
            'statut' => 'inactif'
        ]);

        return redirect()->route('superviseur.stagiaires')
            ->with('success', 'Stagiaire dissocié avec succès');
    }

    public function destroy(Stagiaire $stagiaire)
    {
        if ($stagiaire->superviseur_id !== auth()->guard('superviseur')->id()) {
            abort(403);
        }

        $stagiaire->delete();

        return redirect()->route('superviseur.stagiaires')
            ->with('success', 'Stagiaire supprimé avec succès');
    }

        /**
     * Affiche la liste des tâches
     */
    public function tasks()
    {
        $superviseurId = auth()->guard('superviseur')->id();
        
        $tasks = Tache::whereHas('stagiaire', function($query) use ($superviseurId) {
                $query->where('superviseur_id', $superviseurId);
            })
            ->with('stagiaire')
            ->latest()
            ->get()
            ->map(function($task) {
                $task->formatted_due_date = Carbon::parse($task->date_echeance)->format('d/m/Y');
                $task->status_label = $this->getStatusLabel($task->statut);
                $task->status_class = $this->getStatusBadgeClass($task->statut);
                return $task;
            });
    
        $stagiaires = Stagiaire::where('superviseur_id', $superviseurId)
            ->where('statut', 'actif')
            ->get(['id', 'prenom', 'nom']);
    
        return view('superviseur.tasks', [
            'tasks' => $tasks,
            'stagiaires' => $stagiaires,
            'allStagiairesSelected' => false // Nouvelle variable pour gérer la sélection globale
        ]);
    }

    /**
     * Stocke une nouvelle tâche
     */
    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'stagiaires' => 'required_without:all_stagiaires|array',
            'stagiaires.*' => 'exists:stagiaires,id',
            'all_stagiaires' => 'sometimes|boolean',
            'deadline' => 'required|date',
        ]);
    
        $superviseurId = auth()->guard('superviseur')->id();
        
        // Vérifiez si des stagiaires sont sélectionnés
        if ($request->all_stagiaires) {
            $stagiairesIds = Stagiaire::where('superviseur_id', $superviseurId)
                ->pluck('id')
                ->toArray();
        } else {
            $stagiairesIds = $request->stagiaires ?? [];
        }
    
        // Vérifiez qu'il y a bien des stagiaires sélectionnés
        if (empty($stagiairesIds)) {
            return back()->with('error', 'Aucun stagiaire sélectionné');
        }
    
        foreach ($stagiairesIds as $stagiaireId) {
            Tache::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'pending',
                'deadline' => $request->deadline,
                'stagiaire_id' => $stagiaireId,
                'assigned_by' => $superviseurId,
            ]);
        }
    
        return redirect()->route('superviseur.tasks')
            ->with('success', 'Tâche(s) créée(s) avec succès');
    }

    /**
     * Met à jour le statut d'une tâche
     */
    public function updateTaskStatus(Request $request, Tache $task)
    {
        $request->validate([
            'statut' => 'required|in:en attente,en cours,terminé'
        ]);

        $task->update(['statut' => $request->statut]);

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour',
            'status_label' => $this->getStatusLabel($task->statut),
            'status_class' => $this->getStatusBadgeClass($task->statut)
        ]);
    }

    /**
 * Affiche le formulaire de modification
 */
public function editTask(Tache $task)
{
    $superviseurId = auth()->guard('superviseur')->id();
    
    // Vérification que la tâche appartient bien à un stagiaire du superviseur
    if ($task->stagiaire->superviseur_id !== $superviseurId) {
        abort(403);
    }

    $stagiaires = Stagiaire::where('superviseur_id', $superviseurId)
        ->where('statut', 'actif')
        ->get(['id', 'prenom', 'nom']);

    return view('superviseur.edit-task', [
        'task' => $task,
        'stagiaires' => $stagiaires
    ]);
}

/**
 * Met à jour la tâche
 */
public function updateTask(Request $request, Tache $task)
{
    $superviseurId = auth()->guard('superviseur')->id();
    
    // Vérification d'accès
    if ($task->stagiaire->superviseur_id !== $superviseurId) {
        abort(403);
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'stagiaire_id' => 'required|exists:stagiaires,id',
        'deadline' => 'required|date',
        'status' => 'required|in:pending,in_progress,completed'
    ]);

    $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'stagiaire_id' => $request->stagiaire_id,
        'deadline' => $request->deadline,
        'status' => $request->status
    ]);

    return redirect()->route('superviseur.tasks')
        ->with('success', 'Tâche mise à jour avec succès');
}

    /**
     * Supprime une tâche
     */
    public function destroyTask(Tache $task)
    {
        $task->delete();

        return redirect()->route('superviseur.tasks')
            ->with('success', 'Tâche supprimée avec succès');
    }

    /**
     * Retourne la classe CSS pour le badge de statut
     */
    private function getStatusBadgeClass($status)
    {
        switch ($status) {
            case 'en attente':
                return 'bg-yellow-100 text-yellow-800';
            case 'en cours':
                return 'bg-blue-100 text-blue-800';
            case 'terminé':
                return 'bg-green-100 text-green-800';
            default:
                return 'bg-gray-100';
        }
    }

    /**
     * Retourne le libellé du statut
     */
    private function getStatusLabel($status)
    {
        switch ($status) {
            case 'en attente':
                return 'En attente';
            case 'en cours':
                return 'En cours';
            case 'terminé':
                return 'Terminé';
            default:
                return $status;
        }
    }


    /**
 * Affiche la liste des rapports
 */
public function rapports()
{
    $superviseurId = auth()->guard('superviseur')->id();
    
    $rapports = Rapport::whereHas('stagiaire', function($query) use ($superviseurId) {
            $query->where('superviseur_id', $superviseurId);
        })
        ->with('stagiaire')
        ->latest()
        ->get()
        ->map(function($rapport) {
            $rapport->status_badge = $this->getRapportStatusBadge($rapport->statut);
            return $rapport;
        });

    return view('superviseur.rapports', compact('rapports'));
}

/**
 * Affiche un rapport spécifique
 */
public function showRapport(Rapport $rapport)
{
    $superviseurId = auth()->guard('superviseur')->id();
    
    if ($rapport->stagiaire->superviseur_id !== $superviseurId) {
        abort(403);
    }

    // Debug: Vérification complète du chemin
    $storagePath = 'public/rapports/'.basename($rapport->file_path);
    \Log::info('Vérification fichier rapport', [
        'db_path' => $rapport->file_path,
        'storage_path' => $storagePath,
        'exists' => Storage::exists($storagePath),
        'absolute_path' => storage_path('app/'.$storagePath)
    ]);

    if ($rapport->file_path && Storage::exists('public/rapports/'.basename($rapport->file_path))) {
        $rapport->download_url = route('superviseur.rapports.download', $rapport->id);
    } else {
        $rapport->download_url = null;
    }

    return view('superviseur.rapport-show', compact('rapport'));
}

public function downloadRapport(Rapport $rapport)
{
    $superviseurId = auth()->guard('superviseur')->id();

    if ($rapport->stagiaire->superviseur_id !== $superviseurId) {
        abort(403);
    }

    $filename = basename($rapport->file_path);
    $storagePath = 'public/rapports/'.$filename;

    if (empty($filename)) {
        abort(404, "Aucun fichier associé à ce rapport");
    }

    if (!Storage::exists($storagePath)) {
        abort(404, "Le fichier '$filename' n'existe pas dans storage/app/public/rapports/");
    }

    return Storage::download($storagePath, $rapport->original_name ?? $filename);
}

/**
 * Approuve un rapport
 */
public function approveRapport(Request $request, Rapport $rapport)
{
    $superviseurId = auth()->guard('superviseur')->id();
    $superviseur = auth()->guard('superviseur')->user();

    if ($rapport->stagiaire->superviseur_id !== $superviseurId) {
        abort(403);
    }

    $rapport->update(['statut' => 'approuvé']);

    // Créer une attestation associée avec les valeurs minimales requises
    $attestation = Attestation::create([
        'rapport_id' => $rapport->id,
        'superviseur_id' => $superviseurId,
        'superviseur_name' => $superviseur->prenom . ' ' . $superviseur->nom,
        'company_name' => '', // Valeur par défaut
        'company_address' => '', // Valeur par défaut
        'activities' => json_encode([]), // Tableau vide encodé en JSON
        'statut' => 'en cours',
        'date_generation' => now(),
    ]);

    return redirect()->route('superviseur.rapports.edit-attestation', $attestation)
        ->with('success', 'Rapport approuvé. Vous pouvez maintenant compléter l\'attestation.');
}

/**
 * Rejette un rapport
 */
public function rejectRapport(Request $request, Rapport $rapport)
{
    $request->validate([
        'feedback' => 'required|string|max:500',
    ]);

    $superviseurId = auth()->guard('superviseur')->id();
    
    if ($rapport->stagiaire->superviseur_id !== $superviseurId) {
        abort(403);
    }

    $rapport->update([
        'statut' => 'rejeté',
        'feedback' => $request->feedback,
    ]);

    return redirect()->route('superviseur.rapports.show', $rapport)
        ->with('success', 'Rapport rejeté avec succès.');
}

/**
 * Affiche le formulaire d'édition d'attestation
 */
public function editAttestation(Attestation $attestation)
{
    $superviseurId = auth()->guard('superviseur')->id();
    
    if ($attestation->superviseur_id !== $superviseurId) {
        abort(403);
    }

    return view('superviseur.attestation-edit', compact('attestation'));
}

/**
 * Met à jour une attestation
 */
public function updateAttestation(Request $request, Attestation $attestation)
{
    $request->validate([
        'superviseur_name' => 'required|string|max:255',
        'company_name' => 'required|string|max:255',
        'company_address' => 'required|string',
        'activities' => 'required|array',
        'activities.*' => 'string|max:255',
    ]);

    $superviseurId = auth()->guard('superviseur')->id();
    
    if ($attestation->superviseur_id !== $superviseurId) {
        abort(403);
    }

    $attestation->update([
        'superviseur_name' => $request->superviseur_name,
        'company_name' => $request->company_name,
        'company_address' => $request->company_address,
        'activities' => json_encode($request->activities),
        'statut' => 'complété',
    ]);

    return redirect()->route('superviseur.rapports.show-attestation', $attestation)
        ->with('success', 'Attestation mise à jour avec succès.');
}

/**
 * Affiche une attestation
 */
public function showAttestation(Attestation $attestation)
{
    $superviseurId = auth()->guard('superviseur')->id();
    
    if ($attestation->superviseur_id !== $superviseurId) {
        abort(403);
    }

    return view('superviseur.attestation-show', compact('attestation'));
}

/**
 * Envoie une attestation au stagiaire
 */
public function sendAttestation(Attestation $attestation)
{
    $superviseurId = auth()->guard('superviseur')->id();
    
    if ($attestation->superviseur_id !== $superviseurId) {
        abort(403);
    }

    // Ici vous pourriez ajouter la logique d'envoi par email
    $attestation->update(['date_envoi' => now()]);

    return redirect()->route('superviseur.rapports.show-attestation', $attestation)
        ->with('success', 'Attestation envoyée au stagiaire.');
}

/**
 * Gère la signature de l'attestation
 */
public function signAttestation(Request $request, Attestation $attestation)
{
    $request->validate([
        'signature' => 'required|string', // Base64 encoded image
    ]);

    $superviseurId = auth()->guard('superviseur')->id();
    
    if ($attestation->superviseur_id !== $superviseurId) {
        abort(403);
    }

    // Sauvegarder la signature
    $signaturePath = $this->saveSignature($request->signature);
    
    $attestation->update([
        'signature_path' => $signaturePath,
        'date_signature' => now(),
    ]);

    return response()->json(['success' => true, 'signature_url' => Storage::url($signaturePath)]);
}

/**
 * Retourne le badge HTML pour le statut du rapport
 */
private function getRapportStatusBadge($status)
{
    switch ($status) {
        case 'en attente':
            return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">En attente</span>';
        case 'approuvé':
            return '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Approuvé</span>';
        case 'rejeté':
            return '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Rejeté</span>';
        default:
            return '<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Inconnu</span>';
    }
}

/**
 * Sauvegarde une signature encodée en base64
 */
private function saveSignature($base64Image)
{
    $image = str_replace('data:image/png;base64,', '', $base64Image);
    $image = str_replace(' ', '+', $image);
    $imageName = 'signatures/' . uniqid() . '.png';
    
    Storage::put($imageName, base64_decode($image));
    
    return $imageName;
}

}