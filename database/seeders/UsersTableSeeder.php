<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'dni' => '40123123',
            'role_id' => 1, // admin
            'phone' => '1122334455',
            'active' => true,
        ]);

        // Teachers
        $teachers = [
            ['Pedro Giménez', 'pedro@forza.com', '40111111', '2211111111'],
            ['Laura Torres', 'laura@forza.com', '40222222', '2212222222'],
            ['Diego López', 'diego@forza.com', '40333333', '2213333333'],
        ];

        foreach ($teachers as $t) {
            User::create([
                'name' => $t[0],
                'email' => $t[1],
                'password' => bcrypt('teacher'),
                'dni' => $t[2],
                'role_id' => 2, // teacher
                'phone' => $t[3],
                'active' => true,
            ]);
        }

        // Students
        $students = [
            ['Sofía Martínez', 'sofia@forza.com', '40444444', '2214444444'],
            ['Juan Pérez', 'juan@forza.com', '40555555', '2215555555'],
            ['Martina Gómez', 'martina@forza.com', '40666666', '2216666666'],
        ];

        foreach ($students as $s) {
            User::create([
                'name' => $s[0],
                'email' => $s[1],
                'password' => bcrypt('student'),
                'dni' => $s[2],
                'role_id' => 3, // student
                'phone' => $s[3],
                'active' => true,
            ]);
        }
    }
}
