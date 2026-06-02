<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::withCount('vehiculos')->get();
        return view('admin.marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('admin.marcas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|min:2|max:100',
            'pais_origen' => 'required|string|min:2|max:100',
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'nombre.min'           => 'El nombre debe tener al menos 2 caracteres.',
            'pais_origen.required' => 'El país de origen es obligatorio.',
        ]);

        Marca::create($request->only('nombre', 'pais_origen'));

        return redirect()->route('admin.marcas.index')
            ->with('success', 'Marca creada correctamente.');
    }

    public function edit(Marca $marca)
    {
        return view('admin.marcas.edit', compact('marca'));
    }

    public function update(Request $request, Marca $marca)
    {
        $request->validate([
            'nombre'      => 'required|string|min:2|max:100',
            'pais_origen' => 'required|string|min:2|max:100',
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'pais_origen.required' => 'El país de origen es obligatorio.',
        ]);

        $marca->update($request->only('nombre', 'pais_origen'));

        return redirect()->route('admin.marcas.index')
            ->with('success', 'Marca actualizada correctamente.');
    }

    public function destroy(Marca $marca)
    {
        $marca->delete();
        return redirect()->route('admin.marcas.index')
            ->with('success', 'Marca eliminada correctamente.');
    }
}