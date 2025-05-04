<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Stagiaire;
use App\Models\DemandeStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CompteStagiaireController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        \Log::info('Tentative d\'inscription', $request->all());
    
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('stagiaires', 'email'),
                function ($attribute, $value, $fail) use ($request) {
                    $demande = DemandeStage::where('email', $value)
                              ->where('intern_code', $request->intern_id)
                              ->where('account_created', false)
                              ->first();
                    
                    if (!$demande) {
                        $fail('La combinaison email/code est invalide ou le compte a déjà été créé');
                    }
                }
            ],
            'intern_id' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            // Vérifier que la demande existe
            $demande = DemandeStage::where('email', $validatedData['email'])
                         ->where('intern_code', $validatedData['intern_id'])
                         ->firstOrFail();

            // Création du stagiaire
            $stagiaire = Stagiaire::create([
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'intern_id' => $validatedData['intern_id'],
                'role_id' => Role::where('nom', 'stagiaire')->first()->id,
                'is_validated' => true,
            ]);

            // Marquer la demande comme ayant un compte créé
            $demande->update([
                'account_created' => true,
                'stagiaire_id' => $stagiaire->id
            ]);

            DB::commit();

            // Connexion automatique
            Auth::guard('stagiaire')->login($stagiaire);

            return redirect()->route('stagiaire.dashboard')
                   ->with('success', 'Inscription réussie ! Bienvenue !');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur inscription: '.$e->getMessage());
            
            return back()
                ->with('error', 'Une erreur est survenue lors de la création du compte: '.$e->getMessage())
                ->withInput();
        }
    }
}