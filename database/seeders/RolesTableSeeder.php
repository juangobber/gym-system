<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'Administrador del sistema']);
        Role::create(['name' => 'teacher', 'description' => 'Entrenador o profesor']);
        Role::create(['name' => 'student', 'description' => 'Alumno o socio']);
    }
}
