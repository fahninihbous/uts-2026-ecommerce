<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Panggil seeder lain yang sudah dibuat (User, Category, Product)
        $this->call([
            UserSeeder::class,
        ]);

        // 2. Atau Anda juga bisa tetap menggunakan bawaan Laravel jika ingin menambah user test tambahan:
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}
