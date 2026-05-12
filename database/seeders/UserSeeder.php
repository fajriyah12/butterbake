<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'demo@butterbake.id'],
            [
                'name'     => 'Demo User',
                'password' => Hash::make('password'),
                'phone'    => '08123456789',
            ]
        );
    }
}