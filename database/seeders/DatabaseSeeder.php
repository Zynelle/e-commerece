<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;  // Assure-toi que ce modèle existe
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@maket.com',
            'password' => Hash::make('admin'),
        ]);
    }
}
