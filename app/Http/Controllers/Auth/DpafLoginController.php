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
        $this->guard = 'dpaf'; // Adaptez pour chaque contrôleur
    }

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
        Auth::guard($this->guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/welcome');
    }

    public function redirectTo()
    {
        return route('dpaf.dashboard');
    }
}