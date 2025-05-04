<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompteStagiaireController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        \Log::info('Tentative d\'inscription', $request->all());
    
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:stagiaires,email',
                'intern_id' => 'required|string|exists:demande_stages,intern_code', // Vérifie que le code existe
                'password' => 'required|min:8|confirmed',
            ]);
    
            // Vérification supplémentaire que l'email correspond à une demande avec ce code
            $demande = DemandeStage::where('email', $validated['email'])
                          ->where('intern_code', $validated['intern_id'])
                          ->first();
    
            if (!$demande) {
                return back()->with('error', 'Combinaison email/code invalide');
            }
    
            $role = Role::firstOrCreate(
                ['nom' => 'stagiaire'],
                ['description' => 'Utilisateur stagiaire']
            );
    
            $stagiaireData = [
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'intern_id' => $validated['intern_id'], // Utilise le code fourni
                'role_id' => $role->id,
                'is_validated' => true,
            ];
    
            \Log::info('Données du stagiaire à créer', $stagiaireData);
    
            $stagiaire = Stagiaire::create($stagiaireData);
    
            // Marquer la demande comme complétée
            $demande->update(['account_created' => true]);
    
            \Log::info('Stagiaire créé avec ID: ' . $stagiaire->id);
    
            Auth::guard('stagiaire')->login($stagiaire);
    
            return redirect()->route('stagiaire.dashboard')
                   ->with('success', 'Inscription réussie !');
        } catch (\Exception $e) {
            \Log::error('Erreur d\'inscription: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'inscription');
        }
    }
}