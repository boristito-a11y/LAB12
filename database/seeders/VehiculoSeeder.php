<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;
use App\Models\Vehiculo;

class VehiculoSeeder extends Seeder
{
    public function run(): void
    {
        $toyota  = Marca::where('nombre', 'Toyota')->first();
        $ford    = Marca::where('nombre', 'Ford')->first();
        $bmw     = Marca::where('nombre', 'BMW')->first();
        $honda   = Marca::where('nombre', 'Honda')->first();
        $chevro  = Marca::where('nombre', 'Chevrolet')->first();
        $mercedes= Marca::where('nombre', 'Mercedes-Benz')->first();
        $audi    = Marca::where('nombre', 'Audi')->first();
        $nissan  = Marca::where('nombre', 'Nissan')->first();

        Vehiculo::create(['modelo' => 'Corolla',    'anio' => 2022, 'precio' => 25000, 'kilometraje' => 15000, 'stock' => 8,  'foto' => 'vehiculos/corolla.jpg',  'marca_id' => $toyota->id]);
        Vehiculo::create(['modelo' => 'Hilux',      'anio' => 2021, 'precio' => 38000, 'kilometraje' => 30000, 'stock' => 3,  'foto' => 'vehiculos/Hilux.jpg',    'marca_id' => $toyota->id]);
        Vehiculo::create(['modelo' => 'F-150',      'anio' => 2020, 'precio' => 42000, 'kilometraje' => 50000, 'stock' => 0,  'foto' => 'vehiculos/F-150.jpg',    'marca_id' => $ford->id]);
        Vehiculo::create(['modelo' => 'Mustang',    'anio' => 2023, 'precio' => 55000, 'kilometraje' => 5000,  'stock' => 5,  'foto' => 'vehiculos/mustang.jpg',  'marca_id' => $ford->id]);
        Vehiculo::create(['modelo' => 'Serie 3',    'anio' => 2022, 'precio' => 60000, 'kilometraje' => 12000, 'stock' => 12, 'foto' => 'vehiculos/Serie 3.jpg',  'marca_id' => $bmw->id]);
        Vehiculo::create(['modelo' => 'Civic',      'anio' => 2023, 'precio' => 23000, 'kilometraje' => 8000,  'stock' => 2,  'foto' => 'vehiculos/Civic.jpg',    'marca_id' => $honda->id]);
        Vehiculo::create(['modelo' => 'CR-V',       'anio' => 2022, 'precio' => 32000, 'kilometraje' => 20000, 'stock' => 7,  'foto' => 'vehiculos/CR-V.jpg',     'marca_id' => $honda->id]);
        Vehiculo::create(['modelo' => 'Tracker',    'anio' => 2023, 'precio' => 28000, 'kilometraje' => 5000,  'stock' => 10, 'foto' => 'vehiculos/Tracker.jpg',  'marca_id' => $chevro->id]);
        Vehiculo::create(['modelo' => 'Clase C',    'anio' => 2023, 'precio' => 75000, 'kilometraje' => 3000,  'stock' => 4,  'foto' => 'vehiculos/Clase C.jpg',  'marca_id' => $mercedes->id]);
        Vehiculo::create(['modelo' => 'A4',         'anio' => 2022, 'precio' => 68000, 'kilometraje' => 10000, 'stock' => 1,  'foto' => 'vehiculos/A4.jpg',       'marca_id' => $audi->id]);
        Vehiculo::create(['modelo' => 'Frontier',   'anio' => 2021, 'precio' => 35000, 'kilometraje' => 40000, 'stock' => 6,  'foto' => 'vehiculos/Frontier.jpg', 'marca_id' => $nissan->id]);
    }
}