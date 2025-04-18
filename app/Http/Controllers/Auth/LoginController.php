<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion unique
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traite la connexion pour tous les types d'utilisateurs
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Essai de connexion pour chaque guard
        if (Auth::guard('stagiaire')->attempt($credentials)) {
            return redirect()->route('stagiaire.dashboard');
        }

        if (Auth::guard('dpaf')->attempt($credentials)) {
            return redirect()->route('dpaf.dashboard');
        }

        if (Auth::guard('tuteur')->attempt($credentials)) {
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