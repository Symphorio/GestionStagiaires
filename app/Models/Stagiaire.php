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
    protected $table = 'stagiaires'; // Important!

    protected $fillable = [
        'nom', 
        'prenom', 
        'email', 
        'intern_id', 
        'password', 
        'is_validated',
        'role_id',
        'superviseur_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_validated' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($roleName)
    {
        return $this->role && $this->role->nom === $roleName;
    }

    public static function generateInternId()
    {
        return 'STG-' . strtoupper(Str::random(8));
    }

    // Ajoutez cette relation
public function profile()
{
    return $this->hasOne(Profile::class);
}

public function demandeStage()
{
    return $this->hasOne(DemandeStage::class); // Adaptez selon votre relation réelle
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

// Tache.php
public function stagiaire()
{
    return $this->belongsTo(Stagiaire::class);
}
}