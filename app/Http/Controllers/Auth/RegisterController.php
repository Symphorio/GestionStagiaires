<?php
// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire; // <-- Utilise Stagiaire au lieu de User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255', // <-- Ajouté
            'prenom' => 'required|string|max:255', // <-- Ajouté
            'email' => 'required|string|email|max:255|unique:stagiaires', // <-- Changé (users → stagiaires)
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Génération automatique de l'intern_id
        $intern_id = Stagiaire::generateInternId();

        $stagiaire = Stagiaire::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'intern_id' => $intern_id, // <-- Généré automatiquement
            'password' => Hash::make($request->password),
            'role_id' => 1, // <-- Valeur par défaut (à ajuster si besoin)
        ]);

        // Connexion automatique du stagiaire
        auth('stagiaire')->login($stagiaire);

        // Redirection vers le dashboard stagiaire
        return redirect()->route('stagiaire.dashboard');
    }
}