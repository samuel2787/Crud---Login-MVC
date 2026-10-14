<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Prueba',
            'email' => 'admin@test.com',
            'password' => Hash::make('1234'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Cliente Prueba',
            'email' => 'cliente@test.com',
            'password' => Hash::make('1234'),
            'role' => 'cliente',
        ]);
    }
}
