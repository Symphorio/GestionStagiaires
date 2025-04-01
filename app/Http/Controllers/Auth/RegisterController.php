<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'intern_id' => 'required|string|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'intern_id' => $request->intern_id,
            'password' => Hash::make($request->password),
        ]);

        // Vous pouvez ajouter ici l'envoi d'email ou la connexion automatique

        return redirect()->route('login')->with('success', 'Compte créé avec succès! Vous pouvez maintenant vous connecter.');
    }
}