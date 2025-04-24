<?php

// app/Http/Controllers/CalendrierController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendrierController extends Controller
{
    public function index()
    {
        // Exemple de données (peut venir de votre base de données)
        $events = [
            [
                'date' => '2025-05-15',
                'title' => 'Soutenance de stage',
                'color' => '#3b82f6' // Couleur bleue
            ],
            [
                'date' => '2025-05-20',
                'title' => 'Réunion intermédiaire'
                // Couleur par défaut sera utilisée
            ]
        ];

        return view('calendrier', compact('evenements'));
    }
}