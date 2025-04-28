<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DemandeStage;
use Carbon\Carbon;

class StageController extends Controller
{
    public function afficherFormulaire()
    {
        return view('application-form');
    }

    public function soumettreFormulaire(Request $request)
    {
        // Validation des données
        $reglesValidation = [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'formation' => 'required|string|max:255',
            'specialisation' => 'nullable|string|max:255',
            'lettre_motivation' => 'required|file|mimes:pdf|max:2048', // Modifié pour accepter les fichiers PDF
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ];

        $messages = [
            'required' => 'Le champ :attribute est obligatoire.',
            'email' => 'L\'email doit être une adresse valide.',
            'after' => 'La date de fin doit être après la date de début.',
            'lettre_motivation.mimes' => 'La lettre de motivation doit être un fichier PDF.',
            'lettre_motivation.max' => 'Le fichier ne doit pas dépasser 2MB.',
        ];

        $validation = Validator::make($request->all(), $reglesValidation, $messages);

        // Gestion des erreurs de validation
        if ($validation->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'errors' => $validation->errors(),
                    'message' => 'Veuillez corriger les erreurs du formulaire.'
                ], 422);
            }

            return back()
                ->withErrors($validation)
                ->withInput();
        }

        try {
            // Stockage du fichier PDF
            $lettreMotivationPath = $request->file('lettre_motivation')->store('lettres_motivation', 'public');

            // Création de la demande de stage
            DemandeStage::create([
                'prenom' => $request->prenom,
                'nom' => $request->nom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'formation' => $request->formation,
                'specialisation' => $request->specialisation,
                'lettre_motivation_path' => $lettreMotivationPath, // Champ modifié
                'date_debut' => Carbon::parse($request->date_debut),
                'date_fin' => Carbon::parse($request->date_fin),
                'statut' => 'en_attente', // Ajout d'un statut par défaut
            ]);

            // Réponse pour requête AJAX
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Votre demande a été soumise avec succès! Vous recevrez une réponse par email.',
                    'redirect' => url()->previous()
                ]);
            }

            // Réponse pour soumission normale
            return back()
                ->with('succes', 'Votre demande a été soumise avec succès! Vous recevrez une réponse par email.');

        } catch (\Exception $e) {
            // Journalisation de l'erreur
            \Log::error('Erreur soumission demande de stage: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Une erreur s\'est produite. Veuillez réessayer plus tard.'
                ], 500);
            }

            return back()
                ->with('erreur', 'Une erreur s\'est produite. Veuillez réessayer plus tard.')
                ->withInput();
        }
    }
}