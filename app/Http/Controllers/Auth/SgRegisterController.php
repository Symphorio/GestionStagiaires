<?php

// app/Http/Controllers/Auth/SgRegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SgRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.sg_register-form');
    }

    public function register(Request $request)
{
    try {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sgs',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $sg = Sg::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('sg')->login($sg);

        return redirect(route('sg.dashboard'));

    } catch (\Exception $e) {
        dd($e->getMessage(), $request->all());
    }
}
}