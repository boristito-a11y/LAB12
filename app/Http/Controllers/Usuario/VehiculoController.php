<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use App\Models\Marca;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $query  = Vehiculo::with('marca');
        $marcas = Marca::orderBy('nombre')->get();

        if ($request->filled('buscar')) {
            $query->where('modelo', 'like', '%' . $request->buscar . '%')
                  ->orWhereHas('marca', fn($q) => $q->where('nombre', 'like', '%' . $request->buscar . '%'));
        }

        if ($request->filled('marca_id')) {
            $query->where('marca_id', $request->marca_id);
        }

        if ($request->filled('stock')) {
            match($request->stock) {
                'disponible' => $query->where('stock', '>', 7),
                'medio'      => $query->whereBetween('stock', [4, 7]),
                'bajo'       => $query->whereBetween('stock', [1, 3]),
                'agotado'    => $query->where('stock', 0),
                default      => null
            };
        }

        $vehiculos = $query->get();
        return view('usuario.vehiculos.index', compact('vehiculos', 'marcas'));
    }

    public function show(Vehiculo $vehiculo)
    {
        return view('usuario.vehiculos.show', compact('vehiculo'));
    }
}