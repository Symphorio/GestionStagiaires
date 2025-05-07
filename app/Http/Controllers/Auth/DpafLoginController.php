<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DpafLoginController extends Controller
{
    protected $guard = 'dpaf';

    public function __construct()
    {
        $this->middleware('guest:'.$this->guard)->except('logout');
        $this->guard = 'dpaf';
    }

    public function showLoginForm()
    {
        // Force la déconnexion de tous les guards avant d'afficher le formulaire
        Auth::guard('stagiaire')->logout();
        Auth::guard('sg')->logout();
        Auth::guard('srhds')->logout();
        Auth::guard('superviseur')->logout();
        
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
        Auth::guard($this->guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Ajout d'en-têtes pour empêcher la mise en cache
        return redirect('/')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT'
            ]);
    }

    public function redirectTo()
    {
        return route('dpaf.dashboard');
    }
}