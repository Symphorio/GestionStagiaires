<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Direction Financière'],
            ['name' => 'Direction Technique'],
            ['name' => 'Direction des Ressources Humaines'],
            ['name' => 'Direction Commerciale'],
            ['name' => 'Direction des Systèmes d\'Information'],
            ['name' => 'Direction Juridique'],
            ['name' => 'Direction de la Communication']
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}