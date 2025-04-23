<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stagiaire;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion unique
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Gardez la même vue pour tous les types de connexion
    }

    /**
     * Traite la connexion pour tous les types d'utilisateurs
     * (mais n'utilise que le modèle Stagiaire pour l'instant)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Essai de connexion uniquement avec le guard stagiaire
        if (Auth::guard('stagiaire')->attempt($credentials)) {
            return redirect()->route('stagiaire.dashboard');
        }

        // Gardez ces conditions pour plus tard si vous activez dpaf/tuteur
        if (false && Auth::guard('dpaf')->attempt($credentials)) {
            return redirect()->route('dpaf.dashboard');
        }

        if (false && Auth::guard('tuteur')->attempt($credentials)) {
            return redirect()->route('tuteur.dashboard');
        }

        // Si aucun guard ne fonctionne
        return back()->withErrors([
            'email' => 'Identifiants incorrects ou compte inexistant',
        ]);
    }

    /**
     * Déconnexion pour tous les utilisateurs
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Déconnecte de tous les guards
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}