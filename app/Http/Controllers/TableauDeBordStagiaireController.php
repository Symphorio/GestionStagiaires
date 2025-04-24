<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;
use App\Models\Rapport;
use App\Models\Memoire;
use App\Models\Evenement;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TableauDeBordStagiaireController extends Controller
{
    /**
     * Affiche le tableau de bord principal
     */
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
            $pendingTasks = (clone $tasksQuery)->where('status', 'pending')->count();
            $lateTasks = (clone $tasksQuery)
                        ->where('status', 'pending')
                        ->where('deadline', '<', now())
                        ->count();
            
            $totalTasks = $completedTasks + $pendingTasks + $lateTasks;
            
            // Tâches récentes
            $recentTasks = (clone $tasksQuery)
                         ->orderBy('created_at', 'desc')
                         ->take(3)
                         ->get();

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

    /**
     * Liste toutes les tâches
     */
    public function taches()
    {
        $stagiaireId = auth('stagiaire')->id();
        $taches = Tache::where('stagiaire_id', $stagiaireId)
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('stagiaire.taches', compact('taches'));
    }

    /**
     * Met à jour le statut d'une tâche
     */
    public function updateTaskStatus(Request $request, $taskId)
    {
        $task = Tache::findOrFail($taskId);
        
        $request->validate([
            'status' => 'required|in:pending,completed'
        ]);

        $task->status = $request->input('status');
        $task->save();
        
        return back()->with('success', 'Statut de la tâche mis à jour');
    }

    /**
     * Affiche le calendrier optimisé
     */
    public function calendrier(Request $request)
    {
        $stagiaireId = auth('stagiaire')->id();
        
        $filtreType = $request->input('filtre_type', 'tous');
        $vue = $request->input('vue', 'mois');
        $dateStr = $request->input('date', now()->format('Y-m-d'));
        
        try {
            $dateSelectionnee = Carbon::parse($dateStr);
        } catch (\Exception $e) {
            $dateSelectionnee = now();
        }

        $query = Evenement::where('stagiaire_id', $stagiaireId)
            ->orderBy('date_debut', 'asc');

        if ($filtreType !== 'tous') {
            $query->where('type', $filtreType);
        }

        $evenements = $query->get();
        
        // Formatage des types d'événements
        $evenements->each(function ($event) {
            $event->type_formatted = $this->formatEventType($event->type);
        });

        $evenementsPourDate = $evenements->filter(function ($event) use ($dateSelectionnee) {
            return Carbon::parse($event->date_debut)->isSameDay($dateSelectionnee);
        });

        return view('stagiaire.calendrier', [
            'evenements' => $evenements,
            'evenementsPourDate' => $evenementsPourDate,
            'dateSelectionnee' => $dateSelectionnee,
            'vue' => $vue,
            'filtreType' => $filtreType
        ]);
    }

    /**
     * API pour récupérer les détails d'un événement
     */
    public function getEventDetails($id)
    {
        $evenement = Evenement::findOrFail($id);
        
        if ($evenement->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403);
        }

        return response()->json([
            'id' => $evenement->id,
            'titre' => $evenement->titre,
            'date_debut' => $evenement->date_debut,
            'type' => $evenement->type,
            'type_formatted' => $this->formatEventType($evenement->type),
            'couleur' => $evenement->couleur,
            'description' => $evenement->description
        ]);
    }

    /**
     * Formatte le type d'événement pour l'affichage
     */
    protected function formatEventType($type)
    {
        $types = [
            'echeance' => 'Échéance',
            'reunion' => 'Réunion',
            'formation' => 'Formation',
            'ferie' => 'Jour férié'
        ];

        return $types[$type] ?? $type;
    }

    /**
     * Gestion des rapports
     */
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

    /**
     * Upload d'un rapport
     */
    public function uploadRapport(Request $request)
    {
        $request->validate([
            'report_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'comments' => 'nullable|string|max:500'
        ]);

        $path = $request->file('report_file')->store('rapports');

        Rapport::create([
            'stagiaire_id' => auth('stagiaire')->id(),
            'file_path' => $path,
            'comments' => $request->comments,
            'submitted_at' => now()
        ]);

        return redirect()->route('stagiaire.rapports')
                        ->with('success', 'Rapport soumis avec succès');
    }

    /**
     * Téléchargement d'un rapport
     */
    public function downloadRapport($id)
    {
        $rapport = Rapport::findOrFail($id);
        
        if ($rapport->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403);
        }

        return Storage::download($rapport->file_path);
    }

    /**
     * Gestion des mémoires - Vue liste
     */
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

    /**
     * Upload d'un mémoire
     */
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

    /**
     * Téléchargement d'un mémoire
     */
    public function downloadMemoire($id)
    {
        $memoire = Memoire::findOrFail($id);
        
        if ($memoire->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403);
        }

        return Storage::download($memoire->file_path);
    }

    /**
     * Affiche la page de soumission de mémoire
     */
    public function afficherSoumissionMemoire()
    {
        $stagiaireId = auth('stagiaire')->id();
        
        $dernierMemoire = Memoire::where('stagiaire_id', $stagiaireId)
                               ->latest('created_at')
                               ->first();
    
        return view('stagiaire.soumission-memoire', [
            'memoireSoumis' => !is_null($dernierMemoire),
            'fichierMemoire' => $dernierMemoire ? $dernierMemoire->title : null,
            'dernierMemoire' => $dernierMemoire
        ]);
    }

    /**
     * Traite la soumission d'un mémoire
     */
    public function SoumettreMemoire(Request $request)
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
            'description' => $request->description
        ]);

        return redirect()->route('stagiaire.memoire')
                        ->with('success', 'Mémoire soumis avec succès');
    }

    /**
     * Télécharge un mémoire soumis
     */
    public function telechargerMemoire($id)
    {
        $memoire = Memoire::findOrFail($id);
        
        if ($memoire->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403, 'Accès non autorisé');
        }

        if (!Storage::disk('public')->exists($memoire->file_path)) {
            abort(404, 'Fichier non trouvé');
        }

        return Storage::disk('public')->download($memoire->file_path, $memoire->original_name);
    }

    /**
     * Affiche la liste des événements
     */
    public function evenements()
    {
        $stagiaireId = auth('stagiaire')->id();
        $evenements = Evenement::where('stagiaire_id', $stagiaireId)
                             ->orderBy('date_debut', 'asc')
                             ->get();

        // Formatage des types pour la vue liste
        $evenements->each(function ($event) {
            $event->type_formatted = $this->formatEventType($event->type);
        });

        return view('stagiaire.evenements.index', compact('evenements'));
    }

    /**
     * Affiche le formulaire de création d'événement
     */
    public function createEvenement()
    {
        return view('stagiaire.evenements.create');
    }

    /**
     * Enregistre un nouvel événement
     */
    public function storeEvenement(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'couleur' => 'nullable|string|size:7|starts_with:#',
            'type' => 'required|in:echeance,reunion,formation,ferie'
        ]);

        Evenement::create([
            'stagiaire_id' => auth('stagiaire')->id(),
            'titre' => $request->titre,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'couleur' => $request->couleur ?? $this->getDefaultColor($request->type),
            'type' => $request->type
        ]);

        return redirect()->route('stagiaire.evenements')
                        ->with('success', 'Événement créé avec succès');
    }

    /**
     * Retourne la couleur par défaut selon le type d'événement
     */
    protected function getDefaultColor($type)
    {
        $colors = [
            'echeance' => '#ef4444', // rouge
            'reunion' => '#3b82f6',   // bleu
            'formation' => '#10b981',  // vert
            'ferie' => '#8b5cf6'      // violet
        ];

        return $colors[$type] ?? '#3b82f6'; // bleu par défaut
    }

    /**
     * Affiche le formulaire d'édition d'événement
     */
    public function editEvenement($id)
    {
        $evenement = Evenement::findOrFail($id);
        
        if ($evenement->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403);
        }

        return view('stagiaire.evenements.edit', compact('evenement'));
    }

    /**
     * Met à jour un événement existant
     */
    public function updateEvenement(Request $request, $id)
    {
        $evenement = Evenement::findOrFail($id);
        
        if ($evenement->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403);
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'couleur' => 'nullable|string|size:7|starts_with:#',
            'type' => 'required|in:echeance,reunion,formation,ferie'
        ]);

        $evenement->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'couleur' => $request->couleur ?? $this->getDefaultColor($request->type),
            'type' => $request->type
        ]);

        return redirect()->route('stagiaire.evenements')
                        ->with('success', 'Événement mis à jour avec succès');
    }

    /**
     * Supprime un événement
     */
    public function destroyEvenement($id)
    {
        $evenement = Evenement::findOrFail($id);
        
        if ($evenement->stagiaire_id !== auth('stagiaire')->id()) {
            abort(403);
        }

        $evenement->delete();

        return redirect()->route('stagiaire.evenements')
                        ->with('success', 'Événement supprimé avec succès');
    }

    /**
     * Affiche le profil du stagiaire
     */
    public function profil()
    {
        $stagiaire = auth('stagiaire')->user();
        return view('stagiaire.profil', compact('stagiaire'));
    }

    /**
     * Affiche les paramètres du stagiaire
     */
    public function parametres()
    {
        return view('stagiaire.parametres');
    }
}