<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator Amcor',
                'nik' => '123456',
                'password' => Hash::make('admin123'),
                'role' => 'Administrator',
            ],
            [
                'name' => 'Project Development User',
                'nik' => '223456',
                'password' => Hash::make('pd123'),
                'role' => 'PD',
            ],
            [
                'name' => 'Quality Assurance User',
                'nik' => '323456',
                'password' => Hash::make('qa123'),
                'role' => 'QA',
            ],
            [
                'name' => 'Planner User',
                'nik' => '423456',
                'password' => Hash::make('planner123'),
                'role' => 'PLANNER',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}