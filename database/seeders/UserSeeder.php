<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // User dummy
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User Dummy',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}
