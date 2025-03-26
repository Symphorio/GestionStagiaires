<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeStage extends Model
{
    use HasFactory;

    protected $table = 'demandes_stage';

    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'telephone',
        'formation',
        'specialisation',
        'lettre_motivation',
        'date_debut',
        'date_fin',
    ];

    protected $dates = [
        'date_debut',
        'date_fin',
        'created_at',
        'updated_at',
    ];
}