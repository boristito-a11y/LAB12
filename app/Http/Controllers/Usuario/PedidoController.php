<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('usuario.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }

        $pedido->load('items');
        return view('usuario.pedidos.show', compact('pedido'));
    }
}