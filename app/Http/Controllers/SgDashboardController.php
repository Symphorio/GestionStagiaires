<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use Illuminate\Http\Request;

class SgDashboardController extends Controller
{
    // Colonne de statut confirmée
    protected $statusColumn = 'status';

    // Statuts utilisés dans le système
    protected $statusPending = 'en_attente_sg'; // Statut "en attente SG"
    protected $statusTransferred = 'transferee_dpaf'; // Statut transféré à DPAF

    /**
     * Affiche le tableau de bord principal
     */
    public function index()
    {
        return view('sg.dashboard', [
            'stats' => $this->getDashboardStats(),
            'latestRequests' => $this->getRequests($this->statusPending, 3),
            'totalRequests' => DemandeStage::count()
        ]);
    }

    /**
     * Liste complète des demandes en attente
     */
    public function listRequests()
    {
        return view('sg.requests.index', [
            'requests' => $this->getRequests($this->statusPending)
        ]);
    }

    /**
     * Transfère une demande à la DPAF
     */
    public function forward(Request $request, $id)
    {
        $demande = DemandeStage::findOrFail($id);
        $demande->update([
            $this->statusColumn => $this->statusTransferred
        ]);

        return redirect()
            ->route('sg.dashboard')
            ->with('success', 'Demande transférée avec succès à la DPAF');
    }

    /**
     * Récupère les demandes selon le statut
     */
    protected function getRequests($status, $limit = null)
    {
        $query = DemandeStage::where($this->statusColumn, $status)
            ->latest();
            
        return $limit ? $query->take($limit)->get() : $query->get();
    }

    /**
     * Calcule les statistiques du dashboard
     */
    protected function getDashboardStats()
    {
        $total = DemandeStage::count();
        $pending = DemandeStage::where($this->statusColumn, $this->statusPending)->count();
        $forwarded = DemandeStage::where($this->statusColumn, $this->statusTransferred)->count();

        return [
            'pending' => $pending,
            'forwarded' => $forwarded,
            'transfer_rate' => $total > 0 ? round(($forwarded / $total) * 100) : 0
        ];
    }
}