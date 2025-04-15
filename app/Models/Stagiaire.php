<?php

// app/Models/Stagiaire.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stagiaire extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'email', 'intern_id', 'password', 'is_validated'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
