<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use Illuminate\Http\Request;

class SgDashboardController extends Controller
{
    protected $statusColumn = 'status'; // ou 'statut' selon votre colonne

    public function index()
    {
        $stats = $this->getDashboardStats();
        
        return view('sg.dashboard', [
            'stats' => $stats,
            'latestRequests' => DemandeStage::where($this->statusColumn, 'en_attente_sg')
                                ->latest()
                                ->take(3)
                                ->get(), // Retirez ->with('stagiaire')
            'totalRequests' => DemandeStage::count()
        ]);
    }

    public function newRequests()
    {
        return view('sg.requests.index', [
            'requests' => DemandeStage::where($this->statusColumn, 'en_attente_sg')
                            ->latest()
                            ->paginate(10)
        ]);
    }

    public function forward(Request $request, $id)
    {
        $demande = DemandeStage::findOrFail($id);
        $demande->update([$this->statusColumn => 'transferee_dpaf']);

        return redirect()
                ->route('sg.dashboard')
                ->with('success', 'Demande transférée avec succès à la DPAF');
    }

    protected function getDashboardStats()
    {
        $total = DemandeStage::count();
        $pending = DemandeStage::where($this->statusColumn, 'en_attente_sg')->count();
        $forwarded = DemandeStage::where($this->statusColumn, 'transferee_dpaf')->count();

        return [
            'pending' => $pending,
            'forwarded' => $forwarded,
            'transfer_rate' => $total > 0 ? round(($forwarded / $total) * 100) : 0
        ];
    }
}