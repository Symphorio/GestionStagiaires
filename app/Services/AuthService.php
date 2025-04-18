<?php

namespace App\Services;

use App\Models\Stagiaire;
use App\Models\Dpaf;
use App\Models\Tuteur;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public static function authenticate($credentials)
    {
        $userTypes = [
            'stagiaire' => Stagiaire::class,
            'dpaf' => Dpaf::class,
            'tuteur' => Tuteur::class,
            // Ajoutez d'autres types d'utilisateurs ici
        ];

        foreach ($userTypes as $type => $model) {
            $user = $model::where('email', $credentials['email'])->first();
            
            if ($user && Hash::check($credentials['password'], $user->password)) {
                return $user;
            }
        }

        return null;
    }

    public static function resolveGuard($user)
    {
        return match(get_class($user)) {
            Stagiaire::class => 'stagiaire',
            Dpaf::class => 'dpaf',
            Tuteur::class => 'tuteur',
            default => null
        };
    }
}