<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Import manquant

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
        'lettre_motivation_path',
        'date_debut',
        'date_fin',
        'status',
        'department_id',
        'assigned_department',
        'authorization',
        'intern_code',
        'signature_path',
        'authorized_by',
        'authorized_at',
        'rejected_by',
        'rejected_at',
        'account_created', // Ajoutez cette ligne
        'stagiaire_id', // Ajoutez cette ligne si vous avez une relation avec Stagiaire
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'authorized_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'account_created' => 'boolean', // Ajoutez cette ligne
    ];

    public function getNomCompletAttribute()
    {
        // Si lié à un stagiaire, utilise ses infos
        if ($this->stagiaire) {
            return $this->stagiaire->prenom.' '.$this->stagiaire->nom;
        }
        
        // Sinon utilise les champs directs
        return $this->prenom.' '.$this->nom;
    }

    public function stagiaire(): BelongsTo
    {
        return $this->belongsTo(Stagiaire::class, 'stagiaire_id'); // Spécifiez explicitement la clé étrangère
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function authorizer()
    {
        return $this->belongsTo(Stagiaire::class, 'authorized_by');
    }

    public function rejecter()
    {
        return $this->belongsTo(Stagiaire::class, 'rejected_by');
    }

    public function getSignatureUrlAttribute()
{
    if (!$this->signature_path) {
        return null;
    }
    return Storage::url($this->signature_path);
}
}