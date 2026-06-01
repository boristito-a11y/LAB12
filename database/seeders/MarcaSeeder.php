<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        Marca::create(['nombre' => 'Toyota',        'pais_origen' => 'Japón']);
        Marca::create(['nombre' => 'Ford',          'pais_origen' => 'Estados Unidos']);
        Marca::create(['nombre' => 'BMW',           'pais_origen' => 'Alemania']);
        Marca::create(['nombre' => 'Honda',         'pais_origen' => 'Japón']);
        Marca::create(['nombre' => 'Chevrolet',     'pais_origen' => 'Estados Unidos']);
        Marca::create(['nombre' => 'Mercedes-Benz', 'pais_origen' => 'Alemania']);
        Marca::create(['nombre' => 'Audi',          'pais_origen' => 'Alemania']);
        Marca::create(['nombre' => 'Nissan',        'pais_origen' => 'Japón']);
    }
}