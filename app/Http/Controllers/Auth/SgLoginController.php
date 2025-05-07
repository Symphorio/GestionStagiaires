<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SgLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:sg')->except('logout');
    }

    public function showLoginForm()
    {
        // Force la déconnexion des autres guards
        Auth::guard('stagiaire')->logout();
        Auth::guard('dpaf')->logout();
        Auth::guard('srhds')->logout();
        Auth::guard('superviseur')->logout();
        
        return view('auth.sg_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('sg')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('sg.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('sg')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/sg/login')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT'
            ]);
    }


    public function redirectTo()
    {
        return route('sg.dashboard');
    }
}