<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use App\Models\CarritoItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function index()
    {
        $items   = CarritoItem::with('vehiculo.marca')->where('user_id', Auth::id())->get();
        $carrito = $this->itemsToArray($items);
        $total   = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);
        return view('usuario.carrito.index', compact('carrito', 'total'));
    }

    public function agregar(Vehiculo $vehiculo)
    {
        $stockActual = DB::table('vehiculos')->where('id', $vehiculo->id)->value('stock');

        if ($stockActual <= 0) {
            return redirect()->back()->with('error', 'Este vehículo no tiene stock disponible.');
        }

        DB::table('vehiculos')->where('id', $vehiculo->id)->decrement('stock');

        $item = CarritoItem::where('user_id', Auth::id())
                           ->where('vehiculo_id', $vehiculo->id)
                           ->first();

        if ($item) {
            $item->increment('cantidad');
        } else {
            CarritoItem::create([
                'user_id'     => Auth::id(),
                'vehiculo_id' => $vehiculo->id,
                'cantidad'    => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Vehículo agregado al carrito.');
    }

    public function incrementar($id)
    {
        $item = CarritoItem::where('user_id', Auth::id())
                           ->where('vehiculo_id', $id)->first();

        if (!$item) return redirect()->route('usuario.carrito.index');

        $stockActual = DB::table('vehiculos')->where('id', $id)->value('stock');

        if ($stockActual <= 0) {
            return redirect()->route('usuario.carrito.index')
                ->with('error', 'No hay más unidades disponibles.');
        }

        DB::table('vehiculos')->where('id', $id)->decrement('stock');
        $item->increment('cantidad');

        return redirect()->route('usuario.carrito.index');
    }

    public function decrementar($id)
    {
        $item = CarritoItem::where('user_id', Auth::id())
                           ->where('vehiculo_id', $id)->first();

        if (!$item) return redirect()->route('usuario.carrito.index');

        DB::table('vehiculos')->where('id', $id)->increment('stock');

        if ($item->cantidad > 1) {
            $item->decrement('cantidad');
        } else {
            $item->delete();
        }

        return redirect()->route('usuario.carrito.index');
    }

    public function eliminar($id)
    {
        $item = CarritoItem::where('user_id', Auth::id())
                           ->where('vehiculo_id', $id)->first();

        if ($item) {
            DB::table('vehiculos')->where('id', $id)->increment('stock', $item->cantidad);
            $item->delete();
        }

        return redirect()->route('usuario.carrito.index')
            ->with('success', 'Ítem eliminado del carrito.');
    }

    public function vaciar()
    {
        $items = CarritoItem::where('user_id', Auth::id())->get();

        foreach ($items as $item) {
            DB::table('vehiculos')->where('id', $item->vehiculo_id)
                                  ->increment('stock', $item->cantidad);
        }

        CarritoItem::where('user_id', Auth::id())->delete();

        return redirect()->route('usuario.carrito.index')
            ->with('success', 'Carrito vaciado correctamente.');
    }

    public function comprar()
    {
        $items = CarritoItem::with('vehiculo.marca')->where('user_id', Auth::id())->get();

        if ($items->isEmpty()) {
            return redirect()->route('usuario.carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $carrito   = $this->itemsToArray($items);
        $cantItems = $items->sum('cantidad');
        $total     = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);

        $pedido = \App\Models\Pedido::create([
            'user_id'        => Auth::id(),
            'total'          => $total,
            'cantidad_items' => $cantItems,
        ]);

        foreach ($items as $item) {
            $v      = $item->vehiculo;
            $precio = ($v->en_oferta && $v->precio_oferta) ? $v->precio_oferta : $v->precio;

            \App\Models\PedidoItem::create([
                'pedido_id'   => $pedido->id,
                'vehiculo_id' => $item->vehiculo_id,
                'modelo'      => $v->modelo,
                'marca'       => $v->marca->nombre,
                'precio'      => $precio,
                'cantidad'    => $item->cantidad,
            ]);
        }

        CarritoItem::where('user_id', Auth::id())->delete();

        return view('usuario.carrito.confirmacion', compact('cantItems', 'total', 'carrito', 'pedido'));
    }

    private function itemsToArray($items): array
    {
        $carrito = [];
        foreach ($items as $item) {
            $v      = $item->vehiculo;
            $precio = ($v->en_oferta && $v->precio_oferta) ? $v->precio_oferta : $v->precio;
            $carrito[$v->id] = [
                'id'            => $v->id,
                'nombre'        => $v->modelo . ' ' . $v->marca->nombre,
                'precio'        => $precio,
                'precio_normal' => $v->precio,
                'en_oferta'     => $v->en_oferta && $v->precio_oferta,
                'cantidad'      => $item->cantidad,
                'foto'          => $v->foto,
            ];
        }
        return $carrito;
    }
}