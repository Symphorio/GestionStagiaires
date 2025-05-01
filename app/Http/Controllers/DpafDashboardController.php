<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DpafDashboardController extends Controller
{
    public function dashboard()
    {
        $demandes = DemandeStage::with('stagiaire')->get();
        
        $pendingDPAFDemandes = $demandes->where('status', 'pending_dpaf');
        $departmentAssignedDemandes = $demandes->where('status', 'department_assigned');
        $totalProcessedByDPAF = $demandes->whereNotIn('status', ['pending_dpaf', 'pending_sg'])->count();
        
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
        // Implémentation pour voir toutes les demandes en attente
    }
    
    public function authorizeRequests()
    {
        // Implémentation pour gérer les autorisations
    }
    
    public function forward($id)
    {
        $demande = DemandeStage::findOrFail($id);
        $demande->update(['status' => 'srhds']);
        
        return back()->with('success', 'Demande transférée à SRHDS avec succès');
    }
}