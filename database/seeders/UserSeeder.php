<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@agencia.com',
            'password' => Hash::make('admin1234'),
            'rol'      => 'admin',
        ]);

        User::create([
            'name'     => 'Juan Pérez',
            'email'    => 'juan@agencia.com',
            'password' => Hash::make('user1234'),
            'rol'      => 'usuario',
        ]);
    }
}