<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\MarcaController;
use App\Http\Controllers\Admin\VehiculoController as AdminVehiculoController;
use App\Http\Controllers\Usuario\VehiculoController as UsuarioVehiculoController;
use App\Http\Controllers\Usuario\CarritoController;

Route::get('/',          [AuthController::class, 'showLogin']);
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
Route::get('/registro',  [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro'])->name('registro.post');

Route::middleware(['auth', 'rol:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('marcas', MarcaController::class);

    // ⚠️ Esta ruta va ANTES del resource para que no sea interceptada
    Route::get('vehiculos/exportar-pdf', [AdminVehiculoController::class, 'exportarPdf'])->name('vehiculos.pdf');

    Route::resource('vehiculos', AdminVehiculoController::class);
    Route::patch('vehiculos/{vehiculo}/reajustar', [AdminVehiculoController::class, 'reajustar'])->name('vehiculos.reajustar');
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'rol:usuario'])->prefix('usuario')->name('usuario.')->group(function () {
    Route::get('vehiculos',            [UsuarioVehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('vehiculos/{vehiculo}', [UsuarioVehiculoController::class, 'show'])->name('vehiculos.show');
    Route::get('pedidos',          [App\Http\Controllers\Usuario\PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('pedidos/{pedido}', [App\Http\Controllers\Usuario\PedidoController::class, 'show'])->name('pedidos.show');

    Route::get('carrito',                   [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('carrito/comprar',          [CarritoController::class, 'comprar'])->name('carrito.comprar');
    Route::delete('carrito/vaciar',         [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    Route::post('carrito/{vehiculo}',       [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('carrito/{id}/eliminar',  [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('carrito/{id}/incrementar', [CarritoController::class, 'incrementar'])->name('carrito.incrementar');
    Route::post('carrito/{id}/decrementar', [CarritoController::class, 'decrementar'])->name('carrito.decrementar');

    Route::get('favoritos',             [App\Http\Controllers\Usuario\FavoritoController::class, 'index'])->name('favoritos.index');
    Route::post('favoritos/{vehiculo}', [App\Http\Controllers\Usuario\FavoritoController::class, 'toggle'])->name('favoritos.toggle');
});

Route::middleware('auth')->group(function () {
    Route::get('perfil',          [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('perfil/nombre',   [PerfilController::class, 'updateNombre'])->name('perfil.nombre');
    Route::put('perfil/password', [PerfilController::class, 'updatePassword'])->name('perfil.password');
});