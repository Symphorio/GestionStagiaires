<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\Tache;
use App\Models\Rapport;
use App\Models\Memoire;

class SuperviseurDashboardController extends Controller
{
    public function index()
    {
        // Récupérer l'ID du superviseur connecté
        $superviseurId = auth()->guard('superviseur')->id();

        // Récupérer les statistiques
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

        // Récupérer les stagiaires avec leur progression
        $stagiaires = Stagiaire::where('superviseur_id', $superviseurId)
            ->withCount(['taches as completed_tasks' => function($query) {
                $query->where('statut', 'terminé');
            }])
            ->withCount('taches')
            ->get()
            ->map(function($stagiaire) {
                $stagiaire->progress = $stagiaire->taches_count > 0 
                    ? round(($stagiaire->completed_tasks / $stagiaire->taches_count) * 100)
                    : 0;
                return $stagiaire;
            });

        // Récupérer les dernières tâches
        $taches = Tache::whereHas('stagiaire', function($query) use ($superviseurId) {
                $query->where('superviseur_id', $superviseurId);
            })
            ->with('stagiaire')
            ->latest()
            ->limit(5)
            ->get();

        return view('superviseur.dashboard', compact('stats', 'stagiaires', 'taches'));
    }
}