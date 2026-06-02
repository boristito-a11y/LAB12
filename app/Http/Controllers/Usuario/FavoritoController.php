<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    public function index()
    {
        $favoritos = Favorito::with('vehiculo.marca')
            ->where('user_id', Auth::id())->get();
        return view('usuario.favoritos.index', compact('favoritos'));
    }

    public function toggle(Vehiculo $vehiculo)
    {
        $existe = Favorito::where('user_id', Auth::id())
                          ->where('vehiculo_id', $vehiculo->id)->first();
        if ($existe) {
            $existe->delete();
            return redirect()->back()->with('success', 'Eliminado de favoritos.');
        }

        Favorito::create(['user_id' => Auth::id(), 'vehiculo_id' => $vehiculo->id]);
        return redirect()->back()->with('success', '❤️ Agregado a favoritos.');
    }
}