<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:stagiaire')->except('logout');
    }

    public function showLoginForm()
    {
        // Force la déconnexion de tous les guards avant d'afficher le formulaire
        Auth::guard('sg')->logout();
        Auth::guard('dpaf')->logout();
        
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // ONLY stagiaire guard
        if (Auth::guard('stagiaire')->attempt($credentials)) {
            return redirect()->route('stagiaire.dashboard');
        }
    
        return back()->withErrors([
            'email' => 'Identifiants incorrects',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('stagiaire')->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}