<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Superviseur extends Authenticatable
{
    use Notifiable;

    protected $guard = 'superviseur';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'poste',
        'departement'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}