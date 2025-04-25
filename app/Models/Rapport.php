<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    protected $fillable = [
        'stagiaire_id',
        'file_path',
        'original_name',
        'comments',
        'submitted_at'
    ];

    public function stagiaire()
{
    return $this->belongsTo(Stagiaire::class);
}
}
