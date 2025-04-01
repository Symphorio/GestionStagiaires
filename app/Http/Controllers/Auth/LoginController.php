<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'intern_id' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Vérification supplémentaire de l'ID stagiaire
            $user = Auth::user();
            if ($user->intern_id === $request->intern_id) {
                return redirect()->intended('intern-dashboard');
            }
            
            Auth::logout();
            return back()->withErrors([
                'intern_id' => 'ID stagiaire incorrect',
            ])->withInput();
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects',
        ])->withInput();
    }
}