<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DpafLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.dpaf_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('dpaf')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dpaf.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('dpaf')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/dpaf/login');
    }

    public function redirectTo()
    {
        return route('dpaf.dashboard');
    }
}