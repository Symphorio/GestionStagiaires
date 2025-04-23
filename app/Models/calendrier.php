<?php

namespace App\Models;

// app/Models/Calendrier.php

use Illuminate\Database\Eloquent\Model;

class Calendrier extends Model
{
    protected $fillable = ['titre', 'date', 'type', 'description'];
    
    protected $casts = [
        'date' => 'datetime',
    ];
    
    public function getTypeFormattedAttribute()
    {
        return [
            'echeance' => 'Échéance',
            'reunion' => 'Réunion',
            'formation' => 'Formation',
            'ferie' => 'Jour férié'
        ][$this->type];
    }
    
    public function getCouleurAttribute()
    {
        return [
            'echeance' => 'red',
            'reunion' => 'blue',
            'formation' => 'green',
            'ferie' => 'purple'
        ][$this->type];
    }
}