<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompteStagiaireController extends Controller
{
    // Version temporaire sans vérification d'ID
    public function showRegistrationForm()
    {
        return view('auth.register', [
            'intern_id' => 'temp_'.uniqid(), // Génère un ID temporaire
            'email' => old('email', '') // Valeur par défaut pour l'email
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:stagiaires,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $stagiaire = Stagiaire::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'intern_id' => 'temp_'.uniqid(),
            'is_validated' => true,
            'nom' => 'À compléter', // Champs temporaires
            'prenom' => 'À compléter'
        ]);

        auth()->guard('web')->login($stagiaire);
        
        return redirect()->route('dashboard')
             ->with('success', 'Votre compte a été créé avec succès!');
    }

    // Conservez les méthodes originales pour plus tard
    public function showRegistrationFormWithId($intern_id) { /*...*/ }
    public function registerWithId(Request $request, $intern_id) { /*...*/ }
}