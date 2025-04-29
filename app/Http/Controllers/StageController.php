<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DemandeStage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationStageMail;

class StageController extends Controller
{
    // Affiche le formulaire de demande de stage
    public function afficherFormulaire()
    {
        return view('application-form');
    }

    // Soumet une nouvelle demande de stage
    public function soumettreFormulaire(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'formation' => 'required|string|max:255',
            'specialisation' => 'nullable|string|max:255',
            'lettre_motivation' => 'required|file|mimes:pdf|max:2048',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'email' => 'L\'email doit être une adresse valide.',
            'after' => 'La date de fin doit être après la date de début.',
            'lettre_motivation.mimes' => 'La lettre de motivation doit être un fichier PDF.',
            'lettre_motivation.max' => 'Le fichier ne doit pas dépasser 2MB.',
        ]);

        if ($validator->fails()) {
            return $request->wantsJson()
                ? response()->json(['errors' => $validator->errors()], 422)
                : back()->withErrors($validator)->withInput();
        }

        try {
            $lettrePath = $request->file('lettre_motivation')->store('lettres_motivation', 'public');

            $demande = DemandeStage::create([
                'prenom' => $request->prenom,
                'nom' => $request->nom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'formation' => $request->formation,
                'specialisation' => $request->specialisation,
                'lettre_motivation_path' => $lettrePath,
                'date_debut' => Carbon::parse($request->date_debut),
                'date_fin' => Carbon::parse($request->date_fin),
                'statut' => 'transferee_sg', // Statut initial
                'current_step' => 'sg', // Première étape
            ]);

            // Réponse
            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Demande soumise avec succès!'])
                : back()->with('success', 'Demande soumise avec succès!');

        } catch (\Exception $e) {
            \Log::error('Erreur soumission demande: ' . $e->getMessage());
            
            return $request->wantsJson()
                ? response()->json(['error' => 'Une erreur est survenue'], 500)
                : back()->with('error', 'Erreur lors de la soumission')->withInput();
        }
    }

    // Tableau de bord SG
    public function dashboardSg()
    {
        $demandes = DemandeStage::where('current_step', 'sg')->get();
        return view('dashboard.sg', compact('demandes'));
    }

    // Transférer du SG au DPAF
    public function transfererSgDpaf($id)
    {
        $demande = DemandeStage::findOrFail($id);
        $demande->update([
            'statut' => 'transferee_dpaf',
            'current_step' => 'dpaf'
        ]);
        
        return redirect()->route('dashboard.sg')
            ->with('success', 'Demande transférée au DPAF');
    }

    // Tableau de bord DPAF
    public function dashboardDpaf()
    {
        $demandes = DemandeStage::where('current_step', 'dpaf')->get();
        return view('dashboard.dpaf', compact('demandes'));
    }

    // Transférer du DPAF au SRHDS
    public function transfererDpafSrhds($id)
    {
        $demande = DemandeStage::findOrFail($id);
        $demande->update([
            'statut' => 'transferee_srhds',
            'current_step' => 'srhds'
        ]);
        
        return redirect()->route('dashboard.dpaf')
            ->with('success', 'Demande transférée au SRHDS');
    }

    // Tableau de bord SRHDS
    public function dashboardSrhds()
    {
        $demandes = DemandeStage::where('current_step', 'srhds')->get();
        return view('dashboard.srhds', compact('demandes'));
    }

    // Analyser la demande (SRHDS)
    public function analyserDemande($id)
    {
        $demande = DemandeStage::findOrFail($id);
        $demande->update([
            'statut' => 'analyse_effectuee',
            'current_step' => 'srhds_analyse'
        ]);
        
        return redirect()->route('dashboard.srhds')
            ->with('success', 'Analyse effectuée');
    }

    // Affecter un stagiaire (SRHDS)
    public function affecterStagiaire(Request $request, $id)
    {
        $request->validate([
            'poste_affectation' => 'required|in:secretariat,dsi,comptabilite,dpaf'
        ]);

        $demande = DemandeStage::findOrFail($id);
        $demande->update([
            'poste_affectation' => $request->poste_affectation,
            'statut' => 'affectation_pending',
            'current_step' => 'affectation'
        ]);

        return redirect()->route('dashboard.srhds')
            ->with('success', 'Stagiaire affecté avec succès');
    }

    // Confirmer l'affectation (DPAF)
    public function confirmerAffectation($id)
    {
        $demande = DemandeStage::findOrFail($id);

        DB::table($demande->poste_affectation)->insert([
            'nom' => $demande->nom,
            'prenom' => $demande->prenom,
            'email' => $demande->email,
            'formation' => $demande->formation,
            'date_debut' => $demande->date_debut,
            'date_fin' => $demande->date_fin,
            'demande_stage_id' => $demande->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Envoi de l'email de confirmation
        Mail::to($demande->email)->send(new ConfirmationStageMail($demande));

        $demande->update([
            'statut' => 'confirme',
            'current_step' => 'complete',
            'date_confirmation' => now()
        ]);

        return redirect()->route('dashboard.dpaf')
            ->with('success', 'Affectation confirmée et stagiaire notifié');
    }

    // Visualiser une demande
    public function show($id)
    {
        $demande = DemandeStage::with('historique')->findOrFail($id);
        return view('demandes.show', compact('demande'));
    }

    // Historique des demandes (Admin)
    public function historique()
    {
        $demandes = DemandeStage::orderBy('created_at', 'desc')->get();
        return view('admin.historique', compact('demandes'));
    }

    // Télécharger la lettre de motivation
    public function downloadLettre($id)
    {
        $demande = DemandeStage::findOrFail($id);
        return Storage::disk('public')->download($demande->lettre_motivation_path);
    }

    // API: Liste des demandes
    public function apiDemandes()
    {
        return response()->json(DemandeStage::all());
    }

    // API: Détails d'une demande
    public function apiShow($id)
    {
        return response()->json(DemandeStage::findOrFail($id));
    }
}