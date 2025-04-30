<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeStage extends Model
{
    use HasFactory;

    protected $table = 'demandes_stage';

    protected $fillable = [
        'prenom', // prénom du stagiaire
        'nom',     // nom du stagiaire
        'email',
        'telephone',
        'formation',
        'specialisation',
        'lettre_motivation_path',
        'date_debut',
        'date_fin',
        'status'   // assurez-vous que ce champ existe
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor pour le nom complet
    public function getNomCompletAttribute()
    {
        return $this->prenom.' '.$this->nom;
    }
}