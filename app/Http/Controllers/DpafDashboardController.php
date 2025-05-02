<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use App\Models\Department;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DpafDashboardController extends Controller
{
    public function dashboard()
    {
        // Utilisation de with() pour charger les relations
        $demandes = DemandeStage::with(['stagiaire', 'department'])
            ->where('status', 'transferee_dpaf')
            ->get();
        
        // Statistiques avec whereHas pour les requêtes sur les départements
        $pendingDPAFDemandes = $demandes->where('status', 'transferee_dpaf');
        
        $departmentAssignedDemandes = DemandeStage::with('department')
            ->where('status', 'department_assigned')
            ->get();
            
        $totalProcessedByDPAF = DemandeStage::whereNotIn('status', ['transferee_dpaf', 'pending_sg'])
            ->count();
        
        // Dernières demandes avec tri et eager loading
        $latestPendingDemandes = DemandeStage::with('department')
            ->where('status', 'transferee_dpaf')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        return view('dpaf.dashboard', [
            'pendingDPAFDemandes' => $pendingDPAFDemandes,
            'departmentAssignedDemandes' => $departmentAssignedDemandes,
            'totalProcessedByDPAF' => $totalProcessedByDPAF,
            'latestPendingDemandes' => $latestPendingDemandes,
        ]);
    }
    
    public function pendingRequests()
    {
        // Version optimisée avec eager loading et whereHas
        $demandes = DemandeStage::with(['stagiaire', 'department'])
            ->whereIn('status', ['pending_dpaf', 'transferee_dpaf'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        \Log::debug('Demandes récupérées:', $demandes->toArray());
    
        return view('dpaf.requests-pending', [
            'demandes' => $demandes
        ]);
    }

    public function showRequest($id)
    {
        // Chargement des relations nécessaires
        $demande = DemandeStage::with(['stagiaire', 'department'])
            ->findOrFail($id);
            
        return view('dpaf.request-show', [
            'demande' => $demande,
            'departments' => Department::all() // Pour l'assignation si nécessaire
        ]);
    }

    public function forward($id)
    {
        $demande = DemandeStage::findOrFail($id);
        $demande->update([
            'status' => 'pending_srhds' // Statut cohérent pour le SRHDS
        ]);
    
        return back()->with('success', 'Demande transférée à SRHDS avec succès');
    }

    public function authorizeRequests()
    {
        $demandes = DemandeStage::with(['department']) // On ne charge pas stagiaire car il n'existe pas encore
            ->where('status', 'department_assigned')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('dpaf.authorize', [
            'demandes' => $demandes
        ]);
    }

    public function processAuthorization(Request $request, $id)
    {
        $request->validate([
            'authorized' => 'required|boolean',
            'signature' => 'required_if:authorized,true'
        ]);
    
        $demande = DemandeStage::findOrFail($id);
        $currentUserId = auth()->id();
    
        if ($request->authorized) {
            // Création/liaison du stagiaire seulement si la demande est autorisée
            $stagiaire = Stagiaire::firstOrCreate(
                ['email' => $demande->email],
                [
                    'prenom' => $demande->prenom,
                    'nom' => $demande->nom,
                    'telephone' => $demande->telephone,
                    'formation' => $demande->formation,
                    // Ajoutez ici d'autres champs si nécessaire
                ]
            );

            $demande->update([
                'status' => 'authorized',
                'stagiaire_id' => $stagiaire->id, // Lie la demande au stagiaire
                'authorized_by' => $currentUserId,
                'authorized_at' => now(),
                'signature' => $request->signature,
                'rejected_by' => null,
                'rejected_at' => null,
            ]);
            
            $message = 'Demande autorisée avec signature';
        } else {
            $demande->update([
                'status' => 'rejected',
                'rejected_by' => $currentUserId,
                'rejected_at' => now(),
                'authorized_by' => null,
                'authorized_at' => null,
                'signature' => null
            ]);
            $message = 'Demande refusée';
        }
    
        return back()->with('success', $message);
    }

    // Méthode supplémentaire pour filtrer par département
    public function byDepartment($departmentId)
    {
        $demandes = DemandeStage::with(['stagiaire', 'department'])
            ->whereHas('department', function($query) use ($departmentId) {
                $query->where('id', $departmentId);
            })
            ->where('status', 'transferee_dpaf')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('dpaf.requests-pending', [
            'demandes' => $demandes,
            'department' => Department::find($departmentId)
        ]);
    }
}