<?php

namespace App\Http\Controllers;

use Carbon\Carbon; 
use App\Models\Stagiaire;
use App\Models\Tache;
use App\Models\Rapport;
use App\Models\Memoire;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuperviseurDashboardController extends Controller
{
    public function index()
    {
        $superviseurId = auth()->guard('superviseur')->id();

        $stats = [
            'stagiaires_count' => Stagiaire::where('superviseur_id', $superviseurId)->count(),
            'taches_count' => Tache::whereHas('stagiaire', function($query) use ($superviseurId) {
                $query->where('superviseur_id', $superviseurId);
            })->where('statut', '!=', 'terminé')->count(),
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
            ->whereHas('demandeStage') // <-- Important
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
        return view('superviseur.stagiaire-details', compact('stagiaire'));
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
}