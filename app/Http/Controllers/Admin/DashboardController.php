<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marca;
use App\Models\Vehiculo;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMarcas        = Marca::count();
        $totalVehiculos     = Vehiculo::count();
        $totalUsuarios      = User::where('rol', 'usuario')->count();
        $sinStock           = Vehiculo::where('stock', 0)->count();
        $recientes          = Vehiculo::with('marca')->latest()->take(5)->get();
        $vehiculosBajoStock = Vehiculo::with('marca')->where('stock', '<=', 3)->get();

        // Gráfica: vehículos por marca (versión alternativa sin pedido_items)
        $ventasPorMarca = Marca::withCount('vehiculos')
            ->orderByDesc('vehiculos_count')
            ->get()
            ->map(fn($m) => ['marca' => $m->nombre, 'total_vendidos' => $m->vehiculos_count]);

        return view('admin.dashboard', compact(
            'totalMarcas', 'totalVehiculos', 'totalUsuarios', 'sinStock',
            'recientes', 'vehiculosBajoStock', 'ventasPorMarca'
        ));
    }
}