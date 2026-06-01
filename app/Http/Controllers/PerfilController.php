<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function edit()
    {
        return view('perfil.edit');
    }

    public function updateNombre(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.min'      => 'El nombre debe tener al menos 2 caracteres.',
        ]);

        auth()->user()->update(['name' => $request->name]);

        return redirect()->route('perfil.edit')
            ->with('success', 'Nombre actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password_nuevo'  => 'required|min:8|confirmed',
        ], [
            'password_actual.required' => 'La contraseña actual es obligatoria.',
            'password_nuevo.required'  => 'La nueva contraseña es obligatoria.',
            'password_nuevo.min'       => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password_nuevo.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        if (!Hash::check($request->password_actual, auth()->user()->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
        }

        auth()->user()->update(['password' => Hash::make($request->password_nuevo)]);

        return redirect()->route('perfil.edit')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}