<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationStageMail;
use Illuminate\Support\Str;

class DpafDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:stagiaire');
    }

    public function dashboard()
    {
        $demandes = DemandeStage::with(['stagiaire', 'department'])
            ->where('status', 'transferee_dpaf')
            ->get();

        $pendingDPAFDemandes = $demandes->where('status', 'transferee_dpaf');
        $departmentAssignedDemandes = DemandeStage::where('status', 'department_assigned')->get();
        $totalProcessedByDPAF = DemandeStage::whereNotIn('status', ['transferee_dpaf', 'pending_sg'])->count();
        
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

    public function authorizeRequests()
    {
        $demandes = DemandeStage::where('status', 'department_assigned')
                      ->whereNotNull('department_id')
                      ->with('department')
                      ->orderBy('created_at', 'desc')
                      ->get();

        $hasPendingWithoutDepartment = DemandeStage::where('status', 'transferee_dpaf')
                                          ->whereNull('department_id')
                                          ->exists();

        return view('dpaf.authorize', [
            'demandes' => $demandes,
            'hasPendingWithoutDepartment' => $hasPendingWithoutDepartment
        ]);
    }

    public function showSignaturePad($id)
    {
        $demande = DemandeStage::with('department')->findOrFail($id);

        if ($demande->status !== 'department_assigned' || empty($demande->department_id)) {
            abort(403, 'Cette demande ne peut pas être autorisée');
        }

        return view('dpaf.signature', compact('demande'));
    }

    public function processAuthorization(Request $request, DemandeStage $demande)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'signature' => 'required_if:action,approve|string'
        ]);
    
        try {
            if ($request->action === 'approve') {
                $signatureData = $request->signature;
                
                if (!preg_match('/^data:image\/(png|jpeg|gif);base64,/', $signatureData)) {
                    throw new \Exception('Format de signature invalide');
                }

                if ($demande->signature_path && Storage::disk('public')->exists($demande->signature_path)) {
                    Storage::disk('public')->delete($demande->signature_path);
                }

                $internCode = 'STG-' . strtoupper(Str::random(6));
                Storage::disk('public')->makeDirectory('signatures');
                
                $fileName = 'signatures/sign_'.$demande->id.'_'.time().'.png';
                $imageData = base64_decode(preg_replace('/^data:image\/(png|jpeg|gif);base64,/', '', $signatureData));
                Storage::disk('public')->put($fileName, $imageData);

                $demande->update([
                    'status' => 'approved',
                    'signature_path' => $fileName,
                    'authorized_by' => auth('stagiaire')->id(),
                    'authorized_at' => now(),
                    'intern_code' => $internCode
                ]);

                if ($demande->stagiaire) {
                    $demande->stagiaire->update([
                        'intern_id' => $internCode
                    ]);
                }

                Mail::to($demande->email)->send(new ConfirmationStageMail($demande, $internCode));

                return redirect()->route('dpaf.authorize')
                               ->with([
                                   'success' => 'Demande de '.$demande->prenom.' '.$demande->nom.' approuvée avec succès',
                                   'intern_code' => $internCode,
                                   'email' => $demande->email
                               ]);
                
            } else {
                $demande->update([
                    'status' => 'rejected',
                    'rejected_by' => auth('stagiaire')->id(),
                    'rejected_at' => now()
                ]);

                return redirect()->route('dpaf.authorize')->with('success', 'Demande refusée');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur: '.$e->getMessage());
        }
    }

    public function destroy(DemandeStage $demande)
    {
        try {
            if ($demande->signature_path && Storage::disk('public')->exists($demande->signature_path)) {
                Storage::disk('public')->delete($demande->signature_path);
            }
            
            $demande->delete();
            
            return back()->with('success', 'Demande supprimée avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }
}