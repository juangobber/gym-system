<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstWhere('name', 'admin');
        $teacherRole = Role::firstWhere('name', 'teacher');
        $studentRole = Role::firstWhere('name', 'student');

        if ($adminRole) {
            User::updateOrCreate(
                ['email' => 'admin@admin.com'],
                [
                    'name' => 'Administrador',
                    'password' => Hash::make('admin'),
                    'dni' => '40123123',
                    'role_id' => $adminRole->id,
                    'phone' => '1122334455',
                    'active' => true,
                ]
            );
        }

        $teachers = [
            ['Pedro Giménez', 'pedro@forza.com', '40111111', '2211111111'],
            ['Laura Torres', 'laura@forza.com', '40222222', '2212222222'],
            ['Diego López', 'diego@forza.com', '40333333', '2213333333'],
        ];

        foreach ($teachers as $t) {
            if ($teacherRole) {
                User::updateOrCreate(
                    ['email' => $t[1]],
                    [
                        'name' => $t[0],
                        'password' => Hash::make('teacher'),
                        'dni' => $t[2],
                        'role_id' => $teacherRole->id,
                        'phone' => $t[3],
                        'active' => true,
                    ]
                );
            }
        }

        $students = [
            ['Sofía Martínez', 'sofia@forza.com', '40444444', '2214444444'],
            ['Juan Pérez', 'juan@forza.com', '40555555', '2215555555'],
            ['Martina Gómez', 'martina@forza.com', '40666666', '2216666666'],
        ];

        foreach ($students as $s) {
            if ($studentRole) {
                User::updateOrCreate(
                    ['email' => $s[1]],
                    [
                        'name' => $s[0],
                        'password' => Hash::make('student'),
                        'dni' => $s[2],
                        'role_id' => $studentRole->id,
                        'phone' => $s[3],
                        'active' => true,
                    ]
                );
            }
        }
    }
}
