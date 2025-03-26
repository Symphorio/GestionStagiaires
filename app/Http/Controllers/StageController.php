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
            'lettre_motivation' => 'required|string|min:50',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ];

        $messages = [
            'required' => 'Le champ :attribute est obligatoire.',
            'email' => 'L\'email doit être une adresse valide.',
            'after' => 'La date de fin doit être après la date de début.',
        ];

        $validation = Validator::make($request->all(), $reglesValidation, $messages);

        if ($validation->fails()) {
            return back()
                ->withErrors($validation)
                ->withInput();
        }

        try {
            // Création de la demande de stage
            DemandeStage::create([
                'prenom' => $request->prenom,
                'nom' => $request->nom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'formation' => $request->formation,
                'specialisation' => $request->specialisation,
                'lettre_motivation' => $request->lettre_motivation,
                'date_debut' => Carbon::parse($request->date_debut),
                'date_fin' => Carbon::parse($request->date_fin),
            ]);

            return back()
                ->with('succes', 'Votre demande a été soumise avec succès! Vous recevrez une réponse par email.');
        } catch (\Exception $e) {
            return back()
                ->with('erreur', 'Une erreur s\'est produite. Veuillez réessayer plus tard.')
                ->withInput();
        }
    }
}