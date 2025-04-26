<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $table = 'parametres'; // Spécifie explicitement le nom de la table
    
    protected $fillable = [
        'stagiaire_id',
        'notifications',
        'email_alerts',
        'dark_mode',
        'language'
    ];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}