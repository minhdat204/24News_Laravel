<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'minhdat',
            'email' => 'minhdat@example.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin', // You can set a 'role' column for user roles
        ]);
    }
}