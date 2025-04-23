<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'stagiaire_id',
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'couleur'
    ];

    protected $dates = [
        'date_debut',
        'date_fin',
        'created_at',
        'updated_at'
    ];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}