<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DpafDashboardController extends Controller
{
    public function dashboard()
    {
        // Filtrer directement par status au lieu de current_step
        $demandes = DemandeStage::where('status', 'transferee_dpaf')->get();
        
        // Statistiques
        $pendingDPAFDemandes = $demandes->where('status', 'transferee_dpaf');
        $departmentAssignedDemandes = $demandes->where('status', 'department_assigned');
        $totalProcessedByDPAF = DemandeStage::whereNotIn('status', ['transferee_dpaf', 'pending_sg'])->count();
        
        // Dernières demandes
        $latestPendingDemandes = $pendingDPAFDemandes
            ->sortByDesc('created_at')
            ->take(3);
            
        return view('dpaf.dashboard', [
            'pendingDPAFDemandes' => $pendingDPAFDemandes,
            'departmentAssignedDemandes' => $departmentAssignedDemandes,
            'totalProcessedByDPAF' => $totalProcessedByDPAF,
            'latestPendingDemandes' => $latestPendingDemandes,
        ]);
    }
    
    public function pendingRequests()
    {
        // Version corrigée avec les statuts possibles et relations
        $demandes = DemandeStage::with(['stagiaire'])
            ->whereIn('status', ['pending_dpaf', 'transferee_dpaf']) // Les deux statuts possibles
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Debug: Vérifiez les données récupérées
        \Log::debug('Demandes récupérées:', $demandes->toArray());
    
        return view('dpaf.requests-pending', [
            'demandes' => $demandes
        ]);
    }

    public function showRequest($id)
    {
        $demande = DemandeStage::findOrFail($id);
        return view('dpaf.request-show', ['demande' => $demande]);
    }

    public function forward($id)
    {
        $demande = DemandeStage::findOrFail($id);
        $demande->update(['status' => 'srhds']);

        return back()->with('success', 'Demande transférée à SRHDS avec succès');
    }
}