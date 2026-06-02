<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;
use App\Models\Vehiculo;

class VehiculoSeeder extends Seeder
{
    public function run(): void
    {
        // Marcas originales
        $toyota   = Marca::where('nombre', 'Toyota')->first();
        $ford     = Marca::where('nombre', 'Ford')->first();
        $bmw      = Marca::where('nombre', 'BMW')->first();
        $honda    = Marca::where('nombre', 'Honda')->first();
        $chevro   = Marca::where('nombre', 'Chevrolet')->first();
        $mercedes = Marca::where('nombre', 'Mercedes-Benz')->first();
        $audi     = Marca::where('nombre', 'Audi')->first();
        $nissan   = Marca::where('nombre', 'Nissan')->first();

        // Marcas nuevas
        $vw       = Marca::where('nombre', 'Volkswagen')->first();
        $hyundai  = Marca::where('nombre', 'Hyundai')->first();
        $kia      = Marca::where('nombre', 'Kia')->first();
        $mazda    = Marca::where('nombre', 'Mazda')->first();
        $subaru   = Marca::where('nombre', 'Subaru')->first();
        $jeep     = Marca::where('nombre', 'Jeep')->first();
        $mitsu    = Marca::where('nombre', 'Mitsubishi')->first();

        // ── VEHÍCULOS ORIGINALES (11) ──────────────────────────────────────
        Vehiculo::create(['modelo' => 'Corolla',    'anio' => 2022, 'precio' => 25000, 'kilometraje' => 15000, 'stock' => 8,  'foto' => 'vehiculos/corolla.jpg',    'marca_id' => $toyota->id]);
        Vehiculo::create(['modelo' => 'Hilux',      'anio' => 2021, 'precio' => 38000, 'kilometraje' => 30000, 'stock' => 3,  'foto' => 'vehiculos/Hilux.jpg',      'marca_id' => $toyota->id]);
        Vehiculo::create(['modelo' => 'F-150',      'anio' => 2020, 'precio' => 42000, 'kilometraje' => 50000, 'stock' => 0,  'foto' => 'vehiculos/F-150.jpg',      'marca_id' => $ford->id]);
        Vehiculo::create(['modelo' => 'Mustang',    'anio' => 2023, 'precio' => 55000, 'kilometraje' => 5000,  'stock' => 5,  'foto' => 'vehiculos/mustang.jpg',    'marca_id' => $ford->id]);
        Vehiculo::create(['modelo' => 'Serie 3',    'anio' => 2022, 'precio' => 60000, 'kilometraje' => 12000, 'stock' => 12, 'foto' => 'vehiculos/Serie 3.jpg',    'marca_id' => $bmw->id]);
        Vehiculo::create(['modelo' => 'Civic',      'anio' => 2023, 'precio' => 23000, 'kilometraje' => 8000,  'stock' => 2,  'foto' => 'vehiculos/Civic.jpg',      'marca_id' => $honda->id]);
        Vehiculo::create(['modelo' => 'CR-V',       'anio' => 2022, 'precio' => 32000, 'kilometraje' => 20000, 'stock' => 7,  'foto' => 'vehiculos/CR-V.jpg',       'marca_id' => $honda->id]);
        Vehiculo::create(['modelo' => 'Tracker',    'anio' => 2023, 'precio' => 28000, 'kilometraje' => 5000,  'stock' => 10, 'foto' => 'vehiculos/Tracker.jpg',    'marca_id' => $chevro->id]);
        Vehiculo::create(['modelo' => 'Clase C',    'anio' => 2023, 'precio' => 75000, 'kilometraje' => 3000,  'stock' => 4,  'foto' => 'vehiculos/Clase C.jpg',    'marca_id' => $mercedes->id]);
        Vehiculo::create(['modelo' => 'A4',         'anio' => 2022, 'precio' => 68000, 'kilometraje' => 10000, 'stock' => 1,  'foto' => 'vehiculos/A4.jpg',         'marca_id' => $audi->id]);
        Vehiculo::create(['modelo' => 'Frontier',   'anio' => 2021, 'precio' => 35000, 'kilometraje' => 40000, 'stock' => 6,  'foto' => 'vehiculos/Frontier.jpg',   'marca_id' => $nissan->id]);

        // ── VEHÍCULOS NUEVOS (29) ──────────────────────────────────────────

        // Toyota (4 nuevos)
        Vehiculo::create(['modelo' => 'RAV4',       'anio' => 2023, 'precio' => 34000, 'kilometraje' => 8000,  'stock' => 9,  'foto' => 'vehiculos/RAV4.jpg',       'marca_id' => $toyota->id]);
        Vehiculo::create(['modelo' => 'Yaris',      'anio' => 2022, 'precio' => 18000, 'kilometraje' => 22000, 'stock' => 14, 'foto' => 'vehiculos/Yaris.jpg',       'marca_id' => $toyota->id]);
        Vehiculo::create(['modelo' => 'Land Cruiser','anio' => 2021, 'precio' => 90000, 'kilometraje' => 35000, 'stock' => 2,  'foto' => 'vehiculos/Land Cruiser.jpg','marca_id' => $toyota->id]);
        Vehiculo::create(['modelo' => 'Prius',      'anio' => 2023, 'precio' => 29000, 'kilometraje' => 4000,  'stock' => 7,  'foto' => 'vehiculos/Prius.jpg',       'marca_id' => $toyota->id]);

        // Ford (3 nuevos)
        Vehiculo::create(['modelo' => 'Explorer',   'anio' => 2022, 'precio' => 48000, 'kilometraje' => 18000, 'stock' => 5,  'foto' => 'vehiculos/Explorer.jpg',    'marca_id' => $ford->id]);
        Vehiculo::create(['modelo' => 'Bronco',     'anio' => 2023, 'precio' => 52000, 'kilometraje' => 3000,  'stock' => 3,  'foto' => 'vehiculos/Bronco.jpg',      'marca_id' => $ford->id]);
        Vehiculo::create(['modelo' => 'Escape',     'anio' => 2021, 'precio' => 31000, 'kilometraje' => 28000, 'stock' => 8,  'foto' => 'vehiculos/Escape.jpg',      'marca_id' => $ford->id]);

        // BMW (2 nuevos)
        Vehiculo::create(['modelo' => 'Serie 5',    'anio' => 2022, 'precio' => 80000, 'kilometraje' => 14000, 'stock' => 3,  'foto' => 'vehiculos/Serie 5.jpg',     'marca_id' => $bmw->id]);
        Vehiculo::create(['modelo' => 'X5',         'anio' => 2023, 'precio' => 95000, 'kilometraje' => 5000,  'stock' => 2,  'foto' => 'vehiculos/X5.jpg',          'marca_id' => $bmw->id]);

        // Honda (2 nuevos)
        Vehiculo::create(['modelo' => 'Pilot',      'anio' => 2022, 'precio' => 40000, 'kilometraje' => 16000, 'stock' => 4,  'foto' => 'vehiculos/Pilot.jpg',       'marca_id' => $honda->id]);
        Vehiculo::create(['modelo' => 'HRV',        'anio' => 2023, 'precio' => 27000, 'kilometraje' => 5000,  'stock' => 11, 'foto' => 'vehiculos/HRV.jpg',         'marca_id' => $honda->id]);

        // Chevrolet (2 nuevos)
        Vehiculo::create(['modelo' => 'Camaro',     'anio' => 2022, 'precio' => 50000, 'kilometraje' => 9000,  'stock' => 4,  'foto' => 'vehiculos/Camaro.jpg',      'marca_id' => $chevro->id]);
        Vehiculo::create(['modelo' => 'Silverado',  'anio' => 2021, 'precio' => 45000, 'kilometraje' => 35000, 'stock' => 6,  'foto' => 'vehiculos/Silverado.jpg',   'marca_id' => $chevro->id]);

        // Mercedes-Benz (2 nuevos)
        Vehiculo::create(['modelo' => 'Clase E',    'anio' => 2023, 'precio' => 88000, 'kilometraje' => 4000,  'stock' => 3,  'foto' => 'vehiculos/Clase E.jpg',     'marca_id' => $mercedes->id]);
        Vehiculo::create(['modelo' => 'GLC',        'anio' => 2022, 'precio' => 72000, 'kilometraje' => 11000, 'stock' => 5,  'foto' => 'vehiculos/GLC.jpg',         'marca_id' => $mercedes->id]);

        // Audi (2 nuevos)
        Vehiculo::create(['modelo' => 'Q5',         'anio' => 2023, 'precio' => 72000, 'kilometraje' => 6000,  'stock' => 4,  'foto' => 'vehiculos/Q5.jpg',          'marca_id' => $audi->id]);
        Vehiculo::create(['modelo' => 'A3',         'anio' => 2022, 'precio' => 45000, 'kilometraje' => 18000, 'stock' => 7,  'foto' => 'vehiculos/A3.jpg',          'marca_id' => $audi->id]);

        // Nissan (2 nuevos)
        Vehiculo::create(['modelo' => 'X-Trail',    'anio' => 2023, 'precio' => 33000, 'kilometraje' => 7000,  'stock' => 9,  'foto' => 'vehiculos/X-Trail.jpg',     'marca_id' => $nissan->id]);
        Vehiculo::create(['modelo' => 'Kicks',      'anio' => 2022, 'precio' => 22000, 'kilometraje' => 20000, 'stock' => 13, 'foto' => 'vehiculos/Kicks.jpg',        'marca_id' => $nissan->id]);

        // Volkswagen (3 nuevos)
        Vehiculo::create(['modelo' => 'Golf',       'anio' => 2022, 'precio' => 30000, 'kilometraje' => 13000, 'stock' => 8,  'foto' => 'vehiculos/Golf.jpg',        'marca_id' => $vw->id]);
        Vehiculo::create(['modelo' => 'Tiguan',     'anio' => 2023, 'precio' => 38000, 'kilometraje' => 5000,  'stock' => 6,  'foto' => 'vehiculos/Tiguan.jpg',      'marca_id' => $vw->id]);
        Vehiculo::create(['modelo' => 'Polo',       'anio' => 2021, 'precio' => 19000, 'kilometraje' => 30000, 'stock' => 10, 'foto' => 'vehiculos/Polo.jpg',        'marca_id' => $vw->id]);

        // Hyundai (2 nuevos)
        Vehiculo::create(['modelo' => 'Tucson',     'anio' => 2023, 'precio' => 32000, 'kilometraje' => 6000,  'stock' => 7,  'foto' => 'vehiculos/Tucson.jpg',      'marca_id' => $hyundai->id]);
        Vehiculo::create(['modelo' => 'Elantra',    'anio' => 2022, 'precio' => 23000, 'kilometraje' => 17000, 'stock' => 5,  'foto' => 'vehiculos/Elantra.jpg',     'marca_id' => $hyundai->id]);

        // Kia (2 nuevos)
        Vehiculo::create(['modelo' => 'Sportage',   'anio' => 2023, 'precio' => 33000, 'kilometraje' => 4000,  'stock' => 9,  'foto' => 'vehiculos/Sportage.jpg',    'marca_id' => $kia->id]);
        Vehiculo::create(['modelo' => 'Sorento',    'anio' => 2022, 'precio' => 42000, 'kilometraje' => 14000, 'stock' => 4,  'foto' => 'vehiculos/Sorento.jpg',     'marca_id' => $kia->id]);

        // Mazda (1 nuevo)
        Vehiculo::create(['modelo' => 'CX-5',       'anio' => 2023, 'precio' => 36000, 'kilometraje' => 7000,  'stock' => 6,  'foto' => 'vehiculos/CX-5.jpg',        'marca_id' => $mazda->id]);

        // Subaru (1 nuevo)
        Vehiculo::create(['modelo' => 'Outback',    'anio' => 2022, 'precio' => 38000, 'kilometraje' => 12000, 'stock' => 3,  'foto' => 'vehiculos/Outback.jpg',     'marca_id' => $subaru->id]);

        // Jeep (1 nuevo)
        Vehiculo::create(['modelo' => 'Wrangler',   'anio' => 2023, 'precio' => 55000, 'kilometraje' => 3000,  'stock' => 4,  'foto' => 'vehiculos/Wrangler.jpg',    'marca_id' => $jeep->id]);

        // Mitsubishi (1 nuevo)
        Vehiculo::create(['modelo' => 'Outlander',  'anio' => 2022, 'precio' => 34000, 'kilometraje' => 15000, 'stock' => 5,  'foto' => 'vehiculos/Outlander.jpg',   'marca_id' => $mitsu->id]);
    }
}