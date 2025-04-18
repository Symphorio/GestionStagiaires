<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['nom', 'description'];
    
    // Relation avec stagiaires
    public function stagiaires()
    {
        return $this->hasMany(Stagiaire::class);
    }
    
    // Relations avec les autres modèles
    public function dpaf()
    {
        return $this->hasMany(Dpaf::class);
    }
    // etc.
}