<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Superviseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperviseurAuthController extends Controller
{
    public function index(Request $request)
    {
        $isLogin = $request->has('isLogin') ? (bool)$request->query('isLogin') : true;
        return view('superviseur.index', ['isLogin' => $isLogin]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('superviseur')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/superviseur/dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:superviseurs',
            'password' => 'required|string|min:8|confirmed',
            'poste' => 'required|string',
            'departement' => 'required|string',
        ]);

        $superviseur = Superviseur::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'poste' => $validated['poste'],
            'departement' => $validated['departement'],
        ]);

        Auth::guard('superviseur')->login($superviseur);

        return redirect('/superviseur/dashboard');
    }
}