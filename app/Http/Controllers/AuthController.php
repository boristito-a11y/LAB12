<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $user = auth()->user();

            // Restaurar carrito guardado en DB a la sesión
            if (!$user->esAdmin()) {
                $key = 'carrito_' . $user->id;
                $items = CarritoItem::where('user_id', $user->id)->with('vehiculo.marca')->get();
                $carrito = [];
                foreach ($items as $item) {
                    $v = $item->vehiculo;
                    if ($v) {
                        $carrito[$v->id] = [
                            'id'       => $v->id,
                            'nombre'   => $v->modelo . ' ' . $v->marca->nombre,
                            'precio'   => $v->precio,
                            'cantidad' => $item->cantidad,
                            'foto'     => $v->foto,
                            'stock'    => $v->stock,
                        ];
                    }
                }
                session()->put($key, $carrito);
            }

            return redirect()->route($user->esAdmin() ? 'admin.marcas.index' : 'usuario.vehiculos.index');
        }

        return back()->withErrors(['email' => 'Las credenciales no son correctas.'])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        // Guardar carrito en DB antes de cerrar sesión
        if ($user && !$user->esAdmin()) {
            $key = 'carrito_' . $user->id;
            $carrito = session()->get($key, []);

            CarritoItem::where('user_id', $user->id)->delete();
            foreach ($carrito as $vehiculoId => $item) {
                CarritoItem::create([
                    'user_id'     => $user->id,
                    'vehiculo_id' => $vehiculoId,
                    'cantidad'    => $item['cantidad'],
                ]);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}