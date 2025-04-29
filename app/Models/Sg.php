<?php

// app/Models/Sg.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Sg extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nom', 'description', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
}