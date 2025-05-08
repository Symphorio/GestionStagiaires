<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Stagiaire extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'stagiaire';
    protected $table = 'stagiaires';

    protected $fillable = [
        'nom', 
        'prenom', 
        'email',
        'telephone',
        'intern_id', 
        'password', 
        'is_validated',
        'role_id',
        'superviseur_id',
        'niveau_etudes',
        'specialisation',
        'date_debut',
        'date_fin',
        'statut'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_validated' => 'boolean',
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    // Relations
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function demandeStage()
    {
        return $this->hasOne(DemandeStage::class);
    }

    public function parametres()
    {
        return $this->hasOne(Parametre::class);
    }

    public function superviseur()
    {
        return $this->belongsTo(Superviseur::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeInactifs($query)
    {
        return $query->where('statut', 'inactif');
    }

    public function scopeTermines($query)
    {
        return $query->where('statut', 'termine');
    }

    // Accesseurs
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->prenom, 0, 1) . substr($this->nom, 0, 1));
    }

    // Méthodes
    public function hasRole($roleName)
    {
        return $this->role && $this->role->nom === $roleName;
    }

    public static function generateInternId()
    {
        return 'STG-' . strtoupper(Str::random(8));
    }

    public function estEnCours()
    {
        return $this->statut === 'actif' && 
               now()->between($this->date_debut, $this->date_fin);
    }
}