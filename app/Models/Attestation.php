<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attestation extends Model
{
    protected $fillable = [
        'superviseur_name',
        'company_name',
        'company_address',
        'activities',
        'signature_path',
        'statut',
        'date_generation',
        'date_signature',
        'date_envoi',
        'rapport_id',
        'superviseur_id',
    ];

    protected $casts = [
        'activities' => 'array',
        'date_generation' => 'datetime',
        'date_signature' => 'datetime',
        'date_envoi' => 'datetime',
    ];

    public function rapport(): BelongsTo
    {
        return $this->belongsTo(Rapport::class);
    }

    public function superviseur(): BelongsTo
    {
        return $this->belongsTo(Superviseur::class);
    }
}