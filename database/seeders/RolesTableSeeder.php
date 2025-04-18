<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            ['nom' => 'stagiaire', 'description' => 'Utilisateur stagiaire'],
            ['nom' => 'dpaf', 'description' => 'Direction des affaires pédagogiques'],
            // etc.
        ];
        
        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
