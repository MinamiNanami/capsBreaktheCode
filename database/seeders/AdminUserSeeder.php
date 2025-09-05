<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends \Illuminate\Database\Seeder

{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}

