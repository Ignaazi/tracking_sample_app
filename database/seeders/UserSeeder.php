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
        User::create([
            'name' => 'Administrator Amcor',
            'nik' => '123456', // NIK untuk login kamu nanti, bor!
            'password' => Hash::make('admin123'), // Password di-hash biar aman
            'role' => 'administrator',
        ]);
    }
}