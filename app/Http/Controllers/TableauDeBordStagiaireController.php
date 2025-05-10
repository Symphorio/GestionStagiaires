<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;
use App\Models\Rapport;
use App\Models\Memoire;
use App\Models\Attestation;
use App\Models\Evenement;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class TableauDeBordStagiaireController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            
            if (method_exists($response, 'header')) {
                return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                               ->header('Pragma', 'no-cache')
                               ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
            }
            
            return $response;
        });
    }

    public function dashboard()
{
    try {
        $stagiaireId = auth('stagiaire')->id();
        
        if (!$stagiaireId) {
            throw new \Exception('Utilisateur non authentifié');
        }

        // Statistiques des tâches
        $tasksQuery = Tache::where('stagiaire_id', $stagiaireId);
        
        $completedTasks = (clone $tasksQuery)->where('status', 'completed')->count();
        $pendingTasks = (clone $tasksQuery)->where('status', 'in_progress')->count();
        $lateTasks = (clone $tasksQuery)
                    ->where('status', '!=', 'completed')
                    ->where('deadline', '<', now())
                    ->count();
        
        $totalTasks = $tasksQuery->count();
        
        // Tâches récentes (3 dernières)
        $recentTasks = (clone $tasksQuery)
                     ->with('assignedBy')
                     ->orderBy('created_at', 'desc')
                     ->take(3)
                     ->get()
                     ->map(function($task) {
                         if ($task->status !== 'completed' && $task->deadline < now()) {
                             $task->status = 'late';
                         }
                         return $task;
                     });

        // Événements à venir
        $upcomingEvents = Evenement::where('stagiaire_id', $stagiaireId)
                              ->where('date_debut', '>=', now())
                              ->orderBy('date_debut')
                              ->take(3)
                              ->get();

        return view('stagiaire.dashboard', compact(
            'completedTasks',
            'pendingTasks',
            'lateTasks',
            'totalTasks',
            'recentTasks',
            'upcomingEvents'
        ));

    } catch (\Exception $e) {
        \Log::error('Dashboard Error: '.$e->getMessage());
        
        if(request()->expectsJson()) {
            return response()->json(['error' => 'Erreur du serveur'], 500);
        }
        
        return back()->with('error', 'Une erreur est survenue: '.$e->getMessage());
    }
}

public function taches()
{
    $stagiaireId = auth('stagiaire')->id();
    
    $taches = Tache::with('assignedBy')
        ->where('stagiaire_id', $stagiaireId)
        ->orderBy('deadline', 'asc')
        ->get()
        ->map(function($tache) {
            // Marquer comme échec si date dépassée et statut pas "terminé"
            if (($tache->status === 'pending' || $tache->status === 'in_progress') && $tache->deadline < now()) {
                $tache->status = 'failed';
            }
            return $tache;
        });

    return view('stagiaire.taches', compact('taches'));
}

public function updateTaskStatus(Request $request, Tache $tache)
{
    if ($tache->stagiaire_id !== auth('stagiaire')->id()) {
        abort(403);
    }

    // Empêcher modification si échec ou terminée
    if ($tache->isFailed() || $tache->isCompleted()) {
        return back()->with('error', 'Cette tâche ne peut plus être modifiée');
    }

    $request->validate([
        'status' => 'required|in:in_progress,completed'
    ]);

    $tache->update(['status' => $request->status]);

    return back()->with('success', 'Statut de la tâche mis à jour');
}

    public function rapports()
    {
        $stagiaireId = auth('stagiaire')->id();
        $rapports = Rapport::where('stagiaire_id', $stagiaireId)
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('stagiaire.rapports', [
            'rapports' => $rapports,
            'hasReports' => $rapports->isNotEmpty()
        ]);
    }

public function uploadRapport(Request $request)
{
    $request->validate([
        'report_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        'comments' => 'nullable|string|max:500'
    ]);

    // Stocker dans public/rapports
    $file = $request->file('report_file');
    $path = $file->store('public/rapports');

    // Enregistrer dans la base de données avec le chemin relatif
    Rapport::create([
        'stagiaire_id' => auth('stagiaire')->id(),
        'file_path' => str_replace('public/', '', $path),
        'original_name' => $file->getClientOriginalName(),
        'comments' => $request->comments,
        'submitted_at' => now(),
        'statut' => 'en attente'
    ]);

    return redirect()->route('stagiaire.rapports')
                    ->with('success', 'Rapport soumis avec succès');
}

    public function downloadRapport($id)
    {
        $rapport = Rapport::findOrFail($id);
        
        if ($rapport->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403);
        }

        return response()->file(storage_path('app/'.$rapport->file_path), [
            'Content-Disposition' => 'attachment; filename="'.$rapport->original_name.'"'
        ]);
    }

    public function attestations()
    {
        $stagiaireId = auth('stagiaire')->id();
        
        $attestations = Attestation::whereHas('rapport', function($query) use ($stagiaireId) {
                $query->where('stagiaire_id', $stagiaireId);
            })
            ->with(['rapport', 'superviseur'])
            ->latest('date_generation')
            ->get();

        return view('stagiaire.attestation', compact('attestations'));
    }

    public function downloadAttestation(Attestation $attestation)
    {
        $stagiaireId = auth('stagiaire')->id();
        
        if ($attestation->rapport->stagiaire_id !== $stagiaireId) {
            abort(403);
        }

        if (!$attestation->file_path || !Storage::exists($attestation->file_path)) {
            abort(404, "L'attestation n'est pas encore disponible");
        }

        return response()->file(storage_path('app/'.$attestation->file_path), [
            'Content-Disposition' => 'attachment; filename="attestation-'.$attestation->rapport->stagiaire->nom.'.pdf"'
        ]);
    }

    private function generateAttestationPdf(Attestation $attestation)
    {
        $pdf = app('dompdf.wrapper')->loadView('pdf.attestation', [
            'attestation' => $attestation,
            'activities' => is_array($attestation->activities) ? $attestation->activities : []
        ]);
        
        return $pdf;
    }

    public function memoire()
    {
        $stagiaireId = auth('stagiaire')->id();
        $memoires = Memoire::where('stagiaire_id', $stagiaireId)
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('stagiaire.memoires', [
            'memoires' => $memoires,
            'hasMemoires' => $memoires->isNotEmpty()
        ]);
    }

    public function uploadMemoire(Request $request)
    {
        $request->validate([
            'memoire_file' => 'required|file|mimes:pdf,doc,docx|max:20480',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $path = $request->file('memoire_file')->store('memoires');

        Memoire::create([
            'stagiaire_id' => auth('stagiaire')->id(),
            'title' => $request->title,
            'file_path' => $path,
            'description' => $request->description,
            'submitted_at' => now()
        ]);

        return redirect()->route('stagiaire.memoire')
                        ->with('success', 'Mémoire soumis avec succès');
    }

    public function downloadMemoire($id)
    {
        $memoire = Memoire::findOrFail($id);
        
        if ($memoire->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403);
        }

        return response()->file(storage_path('app/'.$memoire->file_path), [
            'Content-Disposition' => 'attachment; filename="'.$memoire->title.'.'.pathinfo($memoire->file_path, PATHINFO_EXTENSION).'"'
        ]);
    }

    public function afficherSoumissionMemoire()
    {
        $stagiaireId = auth('stagiaire')->id();
        
        $dernierMemoire = Memoire::where('stagiaire_id', $stagiaireId)
                               ->latest('created_at')
                               ->first();
    
        return view('stagiaire.soumission-memoire', [
            'memoireSoumis' => !is_null($dernierMemoire),
            'fichierMemoire' => $dernierMemoire ? $dernierMemoire->title : null,
            'dernierMemoire' => $dernierMemoire,
            'dateSoumission' => $dernierMemoire ? $dernierMemoire->submit_date : null,
            'enRevision' => $dernierMemoire && $dernierMemoire->status === 'revision'
        ]);
    }

    public function soumettreMemoire(Request $request)
    {
        $request->validate([
            'memoire' => 'required|file|mimes:pdf,doc,docx|max:20480',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
    
        $isResubmission = Memoire::where('stagiaire_id', auth('stagiaire')->id())
                                ->where('status', 'revision')
                                ->exists();
    
        $path = $request->file('memoire')->store('public/memoires');
    
        $memoireData = [
            'stagiaire_id' => auth('stagiaire')->id(),
            'title' => $request->titre,
            'file_path' => str_replace('public/', '', $path),
            'summary' => $request->description ?? 'Aucun résumé fourni',
            'field' => 'Non spécifié',
            'submit_date' => now(),
            'status' => 'pending'
        ];
    
        if ($isResubmission) {
            $memoireData['resubmitted_at'] = now();
        }
    
        Memoire::create($memoireData);
    
        return redirect()->route('stagiaire.soumission-memoire')
                        ->with('success', 'Mémoire soumis avec succès');
    }

    public function telechargerMemoire($id)
    {
        $memoire = Memoire::findOrFail($id);
        
        if ($memoire->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403, 'Accès non autorisé');
        }
    
        $filePath = 'public/memoires/' . basename($memoire->file_path);
    
        if (!Storage::exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }
    
        return response()->file(storage_path('app/'.$filePath), [
            'Content-Disposition' => 'attachment; filename="'.$memoire->title.'.'.pathinfo($filePath, PATHINFO_EXTENSION).'"'
        ]);
    }

    public function profil()
    {
        $stagiaire = auth('stagiaire')->user()->load(['demandeStage', 'profile']);
        
        if (!$stagiaire->profile) {
            $stagiaire->profile()->create();
        }

        $profil = [
            'fullName' => $stagiaire->nom.' '.$stagiaire->prenom,
            'email' => $stagiaire->email,
            'phone' => $stagiaire->demandeStage->phone ?? 'Non renseigné',
            'internId' => $stagiaire->intern_id,
            'department' => $stagiaire->demandeStage->department ?? 'Non renseigné',
            'supervisor' => $stagiaire->demandeStage->supervisor ?? 'Non renseigné',
            'period' => $stagiaire->demandeStage->period ?? 'Non renseigné',
            'avatarUrl' => $stagiaire->profile->avatar_path 
                          ? Storage::url($stagiaire->profile->avatar_path)
                          : null
        ];

        return view('stagiaire.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $stagiaire = auth('stagiaire')->user();
        
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars/stagiaires', 'public');
            $stagiaire->profile()->updateOrCreate(
                ['stagiaire_id' => $stagiaire->id],
                ['avatar_path' => $path]
            );
        }

        return back()->with('success', 'Avatar mis à jour avec succès');
    }

    public function parametres()
    {
        $user = auth('stagiaire')->user();
        
        $userParametres = $user->parametres()->firstOrCreate(
            ['stagiaire_id' => $user->id],
            [
                'notifications' => true,
                'email_alerts' => true,
                'dark_mode' => false,
                'language' => 'fr'
            ]
        );

        return view('stagiaire.parametres', compact('userParametres'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'notifications' => 'sometimes|boolean',
            'email_alerts' => 'sometimes|boolean',
            'dark_mode' => 'sometimes|boolean',
            'language' => 'sometimes|in:fr,en'
        ]);

        auth('stagiaire')->user()->parametres()->updateOrCreate(
            ['stagiaire_id' => auth('stagiaire')->id()],
            $validated
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password:stagiaire'
        ]);

        $user = auth('stagiaire')->user();
        
        auth('stagiaire')->logout();
        
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès');
    }
}