<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Memoire extends Model
{
    protected $fillable = [
        'title',
        'stagiaire_id',
        'submit_date',
        'status',
        'summary',
        'field',
        'feedback',
        'file_path',
        'feedback',
        'review_requested_at',
        'resubmitted_at',
    ];

    protected $casts = [
        'submit_date' => 'datetime', // ou 'date'
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'review_requested_at' => 'datetime',
        'resubmitted_at' => 'datetime'
    ];

    public function stagiaire(): BelongsTo
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">En attente</span>',
            'approved' => '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Approuvé</span>',
            'rejected' => '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Rejeté</span>',
            'revision' => '<span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Révision demandée</span>',
            default => '<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Inconnu</span>'
        };
    }

     /**
     * Les valeurs par défaut des attributs.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'en attente', // Valeur par défaut
    ];

    /**
     * Scope pour les mémoires en attente.
     */
    public function scopeEnAttente($query)
    {
        return $query->where('status', 'en attente');
    }

    /**
     * Scope pour les mémoires validés.
     */
    public function scopeValide($query)
    {
        return $query->where('status', 'validé');
    }

    /**
     * Scope pour les mémoires rejetés.
     */
    public function scopeRejete($query)
    {
        return $query->where('status', 'rejeté');
    }

    /**
     * Accesseur pour le status formaté.
     */
    public function getStatusFormateAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Mutateur pour normaliser le status.
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    // Ajoutez cette méthode pour faciliter l'accès au fichier
public function getFilePathAttribute($value)
{
    return 'public/memoires/' . $value;
}
}
