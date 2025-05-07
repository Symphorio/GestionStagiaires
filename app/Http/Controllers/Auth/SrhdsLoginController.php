<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SrhdsLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:srhds')->except('logout');
    }

    public function showLoginForm()
    {
        // Force la déconnexion des autres guards
        Auth::guard('stagiaire')->logout();
        Auth::guard('dpaf')->logout();
        Auth::guard('sg')->logout();
        Auth::guard('superviseur')->logout();
        
        return view('auth.srhds_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('srhds')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('srhds.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('srhds')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/srhds/login')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT'
            ]);
    }
    
    
        public function redirectTo()
        {
            return route('srhds.dashboard');
        }
}