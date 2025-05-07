<?php

// app/Models/Tache.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
        'stagiaire_id',
        'assigned_by',
        'statut'
    ];

    protected $casts = [
        'statut' => 'string'
    ];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}