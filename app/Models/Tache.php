<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    const STATUSES = [
        'pending' => 'En attente',
        'in_progress' => 'En cours',
        'completed' => 'Terminé',
        'late' => 'En retard'
    ];

    protected $fillable = [
        'title',
        'description',
        'status', // Utilisez 'status' partout maintenant
        'deadline',
        'stagiaire_id',
        'assigned_by'
    ];

    protected $casts = [
        'deadline' => 'datetime'
    ];

    // Accessor pour le texte du statut
public function getStatusTextAttribute()
{
    if ($this->status === 'completed') {
        return 'Terminée';
    } elseif ($this->deadline < now() && $this->status !== 'completed') {
        return 'En échec';
    } else {
        return 'En cours';
    }
}

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Superviseur::class, 'assigned_by');
    }
}