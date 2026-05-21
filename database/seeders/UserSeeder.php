<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User biasa
        User::firstOrCreate(
            ['email' => 'demo@butterbake.id'],
            [
                'name'     => 'Demo User',
                'password' => Hash::make('password'),
                'phone'    => '08123456789',
                'role'     => 'user',
            ]
        );

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin123'),
                'phone'    => '08123456780',
                'role'     => 'admin',
            ]
        );
    }
}