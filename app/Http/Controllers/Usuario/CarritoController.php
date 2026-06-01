<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    private function keyCarrito(): string
    {
        return 'carrito_' . Auth::id();
    }

    public function index()
    {
        $carrito = session()->get($this->keyCarrito(), []);
        $total   = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        return view('usuario.carrito.index', compact('carrito', 'total'));
    }

    public function agregar(Vehiculo $vehiculo)
    {
        $vehiculo->refresh(); // stock real de la BD

        if ($vehiculo->stock <= 0) {
            return redirect()->back()->with('error', 'Este vehículo no tiene stock disponible.');
        }

        $key           = $this->keyCarrito();
        $carrito       = session()->get($key, []);
        $cantEnCarrito = isset($carrito[$vehiculo->id]) ? $carrito[$vehiculo->id]['cantidad'] : 0;

        if ($cantEnCarrito >= $vehiculo->stock) {
            return redirect()->back()->with('error', 'No hay más unidades disponibles.');
        }

        // Descontar 1 del stock en BD
        DB::transaction(function () use ($vehiculo) {
            $vehiculo->decrement('stock');
        });

        if (isset($carrito[$vehiculo->id])) {
            $carrito[$vehiculo->id]['cantidad']++;
        } else {
            $carrito[$vehiculo->id] = [
                'id'       => $vehiculo->id,
                'nombre'   => $vehiculo->modelo . ' ' . $vehiculo->marca->nombre,
                'precio'   => $vehiculo->precio,
                'cantidad' => 1,
                'foto'     => $vehiculo->foto,
                'stock'    => $vehiculo->stock,
            ];
        }

        session()->put($key, $carrito);
        return redirect()->back()->with('success', 'Vehículo agregado al carrito.');
    }

    public function incrementar($id)
    {
        $key     = $this->keyCarrito();
        $carrito = session()->get($key, []);

        if (!isset($carrito[$id])) {
            return redirect()->route('usuario.carrito.index');
        }

        $vehiculo = Vehiculo::find($id);

        if (!$vehiculo || $vehiculo->stock <= 0) {
            return redirect()->route('usuario.carrito.index')
                ->with('error', 'No hay más unidades disponibles.');
        }

        DB::transaction(function () use ($vehiculo) {
            $vehiculo->decrement('stock');
        });

        $carrito[$id]['cantidad']++;
        session()->put($key, $carrito);

        return redirect()->route('usuario.carrito.index');
    }

    public function decrementar($id)
    {
        $key     = $this->keyCarrito();
        $carrito = session()->get($key, []);

        if (!isset($carrito[$id])) {
            return redirect()->route('usuario.carrito.index');
        }

        // Devolver 1 al stock en BD
        DB::transaction(function () use ($id) {
            Vehiculo::where('id', $id)->increment('stock');
        });

        if ($carrito[$id]['cantidad'] > 1) {
            $carrito[$id]['cantidad']--;
        } else {
            unset($carrito[$id]);
        }

        session()->put($key, $carrito);
        return redirect()->route('usuario.carrito.index');
    }

    public function eliminar($id)
    {
        $key     = $this->keyCarrito();
        $carrito = session()->get($key, []);

        if (isset($carrito[$id])) {
            $cantidad = $carrito[$id]['cantidad'];

            // Devolver TODAS las unidades al stock en BD
            DB::transaction(function () use ($id, $cantidad) {
                Vehiculo::where('id', $id)->increment('stock', $cantidad);
            });

            unset($carrito[$id]);
            session()->put($key, $carrito);
        }

        return redirect()->route('usuario.carrito.index')->with('success', 'Ítem eliminado del carrito.');
    }

    public function vaciar()
    {
        $key     = $this->keyCarrito();
        $carrito = session()->get($key, []);

        // Devolver todo el stock a la BD
        DB::transaction(function () use ($carrito) {
            foreach ($carrito as $id => $item) {
                Vehiculo::where('id', $id)->increment('stock', $item['cantidad']);
            }
        });

        session()->forget($key);
        return redirect()->route('usuario.carrito.index')->with('success', 'Carrito vaciado correctamente.');
    }

    public function comprar()
    {
        $key     = $this->keyCarrito();
        $carrito = session()->get($key, []);

        if (empty($carrito)) {
            return redirect()->route('usuario.carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        $cantItems = collect($carrito)->sum('cantidad');
        $total     = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);

        // El stock ya fue descontado al agregar; solo vaciamos sesión
        session()->forget($key);

        return view('usuario.carrito.confirmacion', compact('cantItems', 'total', 'carrito'));
    }
}