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
        'status',   // assurez-vous que ce champ existe
        'authorized_by',
        'authorized_at',
        'rejected_by',
        'rejected_at',
        'signature'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'authorized_at',
        'rejected_at',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor pour le nom complet
    public function getNomCompletAttribute()
    {
        return $this->prenom.' '.$this->nom;
    }

    public function stagiaire()
{
    return $this->belongsTo(Stagiaire::class);
}

public function department()
{
    return $this->belongsTo(Department::class);
}

// Relation avec le stagiaire qui a autorisé
public function authorizer()
{
    return $this->belongsTo(Stagiaire::class, 'authorized_by');
}

// Relation avec le stagiaire qui a rejeté
public function rejecter() 
{
    return $this->belongsTo(Stagiaire::class, 'rejected_by');
}
}