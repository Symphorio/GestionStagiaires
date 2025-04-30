<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dpaf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Ajoutez cette ligne
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DpafRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.dpaf_register-form');
    }

    public function register(Request $request)
{
    $this->validator($request->all())->validate();

    $dpaf = $this->create($request->all());

    Auth::guard('dpaf')->login($dpaf); // Utilisez Auth::guard directement

    return redirect()->route('dpaf.dashboard');
}

    protected function validator(array $data)
{
    return Validator::make($data, [
        'nom' => ['required', 'string', 'max:255'], // Changé de 'name' à 'nom'
        'email' => ['required', 'string', 'email', 'max:255', 'unique:dpafs'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
}

protected function create(array $data)
{
    return Dpaf::create([
        'nom' => $data['nom'], // Changé de 'name' à 'nom'
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);
}

    public function redirectTo()
    {
        return route('dpaf.dashboard');
    }
}