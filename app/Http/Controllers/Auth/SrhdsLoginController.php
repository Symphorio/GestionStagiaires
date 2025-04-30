<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SrhdsLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.srhds_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('srhds')->attempt($credentials, $request->remember)) {
            return redirect()->intended(route('srhds.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout()
    {
        Auth::guard('srhds')->logout();
        return redirect('/srhds/login');
    }
}