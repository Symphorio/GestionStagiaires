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
    
    
    public function __construct()
{
    $this->middleware(function ($request, $next) {
        $response = $next($request);
        
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
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

    $file = $request->file('report_file');
    $path = $file->store('rapports');

    Rapport::create([
        'stagiaire_id' => auth('stagiaire')->id(),
        'file_path' => $path,
        'original_name' => $file->getClientOriginalName(),
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

    return Storage::download(
        $rapport->file_path, 
        $rapport->original_name
    );
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
     * Affiche le profil du stagiaire
     */
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

    /**
 * Affiche les paramètres du stagiaire
 */
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

/**
 * Met à jour les paramètres
 */
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

/**
 * Supprime le compte
 */
public function destroy(Request $request)
{
    $request->validate([
        'password' => 'required|current_password:stagiaire'
    ]);

    $user = auth('stagiaire')->user();
    
    // Déconnexion avant suppression
    auth('stagiaire')->logout();
    
    // Suppression de l'utilisateur
    $user->delete();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'Votre compte a été supprimé avec succès');
}
}