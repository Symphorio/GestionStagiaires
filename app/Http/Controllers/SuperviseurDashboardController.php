<?php

namespace App\Http\Controllers;

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
        
        // Stagiaires actifs
        $activeStagiaires = Stagiaire::where('superviseur_id', $superviseurId)
            ->where('statut', 'actif')
            ->with(['taches', 'demandeStage'])
            ->withCount([
                'taches as taches_completees' => function($query) {
                    $query->where('statut', 'terminé');
                },
                'taches as taches_total'
            ])
            ->get()
            ->map(function($stagiaire) {
                $stagiaire->progress = $stagiaire->taches_total > 0 
                    ? round(($stagiaire->taches_completees / $stagiaire->taches_total) * 100, 2)
                    : 0;
                return $stagiaire;
            });

        // Stagiaires terminés
        $completedStagiaires = Stagiaire::where('superviseur_id', $superviseurId)
            ->where('statut', 'terminé')
            ->with(['taches', 'demandeStage'])
            ->withCount([
                'taches as taches_completees' => function($query) {
                    $query->where('statut', 'terminé');
                },
                'taches as taches_total'
            ])
            ->get()
            ->map(function($stagiaire) {
                $stagiaire->progress = $stagiaire->taches_total > 0 
                    ? round(($stagiaire->taches_completees / $stagiaire->taches_total) * 100, 2)
                    : 100;
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