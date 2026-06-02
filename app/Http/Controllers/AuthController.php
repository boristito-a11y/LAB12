<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Ingresa un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            if (auth()->user()->esAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('usuario.vehiculos.index');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegistro()
    {
        return view('auth.registro');
    }

    public function registro(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:2|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'name.min'           => 'El nombre debe tener al menos 2 caracteres.',
            'email.required'     => 'El correo es obligatorio.',
            'email.unique'       => 'Este correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => 'usuario',
        ]);

        Auth::login($user);
        return redirect()->route('usuario.vehiculos.index')
            ->with('success', '¡Bienvenido ' . $user->name . '!');
    }
}