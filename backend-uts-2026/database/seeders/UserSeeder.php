<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@providential.com'],
            [
                'name' => 'Admin Providential',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Customer / Pembeli biasa
        User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Budi Customer',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );
    }
}
