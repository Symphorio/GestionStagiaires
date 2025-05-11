<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'avatar_path', 
        'department',
        'supervisor',
        'bio'
    ];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}