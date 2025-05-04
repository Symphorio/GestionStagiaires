<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DemandeStage;
use App\Models\Department;
use Illuminate\Http\Request;

class SrhdsDashboardController extends Controller
{
    private $departments;

    public function __construct()
    {
        $this->middleware('auth:srhds');
        
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            
            return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                           ->header('Pragma', 'no-cache')
                           ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        });

        $this->departments = Department::all();
    }

    public function index()
    {
        $pendingSRHDSRequests = DemandeStage::with('department')
            ->where('status', 'pending_srhds')
            ->orderBy('created_at', 'desc')
            ->get();

        $authorizedRequests = DemandeStage::where('status', 'authorized')->get();
        $approvedRequests = DemandeStage::where('status', 'approved')->get();
        $latestPendingRequests = $pendingSRHDSRequests->take(3);

        $requestsNeedingDepartment = $pendingSRHDSRequests->filter(function($item) {
            return empty($item->department_id);
        });

        return view('srhds.dashboard', [
            'pendingSRHDSRequests' => $pendingSRHDSRequests,
            'authorizedRequests' => $authorizedRequests,
            'approvedRequests' => $approvedRequests,
            'latestPendingRequests' => $latestPendingRequests,
            'requestsNeedingDepartment' => $requestsNeedingDepartment,
            'departments' => $this->departments
        ]);
    }

    public function assign()
    {
        $demandes = DemandeStage::with('department')
            ->where('status', 'pending_srhds')
            ->whereNull('department_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('srhds.assign', [
            'demandes' => $demandes,
            'departments' => $this->departments
        ]);
    }

    public function assignDepartment(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id'
        ]);
    
        $demande = DemandeStage::findOrFail($id);
        $demande->update([
            'department_id' => $request->department_id,
            'status' => 'department_assigned' // Ce statut sera utilisé par DPAF pour l'autorisation
        ]);
    
        return redirect()->route('srhds.assign')
               ->with('success', 'Département assigné avec succès. La demande a été renvoyée au DPAF pour autorisation.');
    }

    public function showRequest($id)
    {
        $demande = DemandeStage::with('department')->findOrFail($id);
        return view('srhds.request-show', [
            'demande' => $demande,
            'departments' => $this->departments
        ]);
    }
}