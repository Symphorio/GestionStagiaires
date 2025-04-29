<?php

// app/Http/Controllers/Auth/SgLoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SgLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.sg_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('sg')->attempt($credentials, $request->remember)) {
            return redirect()->intended(route('sg.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ]);
    }

    public function logout()
    {
        Auth::guard('sg')->logout();
        return redirect('/sg/login');
    }
}