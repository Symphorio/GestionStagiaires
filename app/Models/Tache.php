<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status', 'deadline', 'stagiaire_id', 'assigned_by'
    ];

    protected $casts = [
        'deadline' => 'datetime'
    ];

    const STATUSES = [
        'pending' => 'En attente',
        'in_progress' => 'En cours',
        'completed' => 'Terminée',
        'failed' => 'Échec'
    ];

    // Relations
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Superviseur::class, 'assigned_by');
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        if ($this->status === 'completed') {
            return 'Terminée';
        } elseif (($this->status === 'pending' || $this->status === 'in_progress') && $this->deadline < now()) {
            return 'Échec';
        }
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getStatusClassAttribute()
    {
        if ($this->status === 'completed') {
            return 'bg-green-100 text-green-800';
        } elseif (($this->status === 'pending' || $this->status === 'in_progress') && $this->deadline < now()) {
            return 'bg-red-100 text-red-800';
        } elseif ($this->status === 'in_progress') {
            return 'bg-blue-100 text-blue-800';
        }
        return 'bg-gray-100 text-gray-800'; // En attente
    }

    public function isFailed()
    {
        return ($this->status === 'pending' || $this->status === 'in_progress') && $this->deadline < now();
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}