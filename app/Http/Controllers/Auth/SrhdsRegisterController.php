<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Srhds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SrhdsRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.srhds_register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:srhds',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $srhds = Srhds::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('srhds')->login($srhds);

        return redirect()->route('srhds.dashboard');
    }
}