<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attestation extends Model
{
    const STATUS_IN_PROGRESS = 'en cours';
    const STATUS_COMPLETED = 'complété';
    const STATUS_SENT = 'envoyé';
    const STATUS_SIGNED = 'signé';

    protected $fillable = [
        'rapport_id',
        'superviseur_id',
        'superviseur_name',
        'company_name',
        'company_address',
        'activities',
        'statut',
        'date_generation',
        'date_signature',
        'signature_path',
        'date_envoi',
        'file_path'
    ];

    protected $casts = [
        'activities' => 'array',
        'date_generation' => 'datetime',
        'date_signature' => 'datetime',
        'date_envoi' => 'datetime',
    ];

    public function getActivitiesAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }
        
        if (is_string($value) && $decoded = json_decode($value, true)) {
            return $decoded;
        }
        
        return [];
    }

    public function rapport()
    {
        return $this->belongsTo(Rapport::class);
    }

    public function superviseur()
    {
        return $this->belongsTo(Superviseur::class);
    }

    public function markAsSent()
    {
        $this->update([
            'statut' => self::STATUS_SENT,
            'date_envoi' => now()
        ]);
    }

    public function getSignatureUrlAttribute()
    {
        return $this->signature_path ? Storage::url($this->signature_path) : null;
    }
}