<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::with('marca')->get();
        return view('admin.vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        $marcas = Marca::all();
        return view('admin.vehiculos.create', compact('marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'modelo'      => 'required|string|min:2|max:150',
            'anio'        => 'required|integer|min:1900|max:2099',
            'precio'      => 'required|numeric|min:0',
            'kilometraje' => 'required|integer|min:0',
            'marca_id'    => 'required|exists:marcas,id',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'modelo.required'      => 'El modelo es obligatorio.',
            'anio.required'        => 'El año es obligatorio.',
            'precio.required'      => 'El precio es obligatorio.',
            'kilometraje.required' => 'El kilometraje es obligatorio.',
            'marca_id.required'    => 'Debes seleccionar una marca.',
            'foto.image'           => 'El archivo debe ser una imagen.',
            'foto.mimes'           => 'Solo se permiten imágenes jpg, jpeg, png o gif.',
        ]);

        $datos = $request->only('modelo', 'anio', 'precio', 'kilometraje', 'marca_id');
        $datos['en_oferta']     = $request->has('en_oferta');
        $datos['precio_oferta'] = $request->has('en_oferta') ? $request->precio_oferta : null;

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('vehiculos', 'public');
        }

        Vehiculo::create($datos);

        return redirect()->route('admin.vehiculos.index')
            ->with('success', 'Vehículo creado correctamente.');
    }

    public function show(Vehiculo $vehiculo)
    {
        return view('admin.vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        $marcas = Marca::all();
        return view('admin.vehiculos.edit', compact('vehiculo', 'marcas'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate([
            'modelo'      => 'required|string|min:2|max:150',
            'anio'        => 'required|integer|min:1900|max:2099',
            'precio'      => 'required|numeric|min:0',
            'kilometraje' => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'marca_id'    => 'required|exists:marcas,id',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'modelo.required'      => 'El modelo es obligatorio.',
            'anio.required'        => 'El año es obligatorio.',
            'precio.required'      => 'El precio es obligatorio.',
            'kilometraje.required' => 'El kilometraje es obligatorio.',
            'stock.required'       => 'El stock es obligatorio.',
            'marca_id.required'    => 'Debes seleccionar una marca.',
            'foto.image'           => 'El archivo debe ser una imagen.',
            'foto.mimes'           => 'Solo se permiten imágenes jpg, jpeg, png o gif.',
        ]);

        $datos = $request->only('modelo', 'anio', 'precio', 'kilometraje', 'stock', 'marca_id');
        $datos['en_oferta']     = $request->has('en_oferta');
        $datos['precio_oferta'] = $request->has('en_oferta') ? $request->precio_oferta : null;

        if ($request->hasFile('foto')) {
            if ($vehiculo->foto) {
                Storage::disk('public')->delete($vehiculo->foto);
            }
            $datos['foto'] = $request->file('foto')->store('vehiculos', 'public');
        }

        $vehiculo->update($datos);

        return redirect()->route('admin.vehiculos.index')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        if ($vehiculo->foto) {
            Storage::disk('public')->delete($vehiculo->foto);
        }
        $vehiculo->delete();
        return redirect()->route('admin.vehiculos.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }

    public function reajustar(Request $request, Vehiculo $vehiculo)
    {
        $request->validate(['stock' => 'required|integer|min:0']);
        $vehiculo->update(['stock' => $request->stock]);
        return redirect()->route('admin.dashboard')
            ->with('success', 'Stock de ' . $vehiculo->modelo . ' actualizado.');
    }

    // NUEVO: Exportar PDF
    public function exportarPdf()
    {
        $vehiculos = Vehiculo::with('marca')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.vehiculos.pdf', compact('vehiculos'));
        return $pdf->download('vehiculos-' . now()->format('Y-m-d') . '.pdf');
    }
}