<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memoire extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'fichier',
        'date_soumission',
        'statut', // Ajout du champ statut
        'stagiaire_id',
        'notes',
        'feedback'
    ];

    /**
     * Les valeurs par défaut des attributs.
     *
     * @var array
     */
    protected $attributes = [
        'statut' => 'en attente', // Valeur par défaut
    ];

    /**
     * Relation avec le modèle Stagiaire.
     */
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    /**
     * Scope pour les mémoires en attente.
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en attente');
    }

    /**
     * Scope pour les mémoires validés.
     */
    public function scopeValide($query)
    {
        return $query->where('statut', 'validé');
    }

    /**
     * Scope pour les mémoires rejetés.
     */
    public function scopeRejete($query)
    {
        return $query->where('statut', 'rejeté');
    }

    /**
     * Accesseur pour le statut formaté.
     */
    public function getStatutFormateAttribute()
    {
        return ucfirst($this->statut);
    }

    /**
     * Mutateur pour normaliser le statut.
     */
    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = strtolower($value);
    }
}