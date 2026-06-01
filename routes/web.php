<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\MarcaController;
use App\Http\Controllers\Admin\VehiculoController as AdminVehiculoController;
use App\Http\Controllers\Usuario\VehiculoController as UsuarioVehiculoController;
use App\Http\Controllers\Usuario\CarritoController;

Route::get('/',        [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'rol:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('marcas',    MarcaController::class);
    Route::resource('vehiculos', AdminVehiculoController::class);
});

Route::middleware(['auth', 'rol:usuario'])->prefix('usuario')->name('usuario.')->group(function () {
    Route::get('vehiculos',            [UsuarioVehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('vehiculos/{vehiculo}', [UsuarioVehiculoController::class, 'show'])->name('vehiculos.show');

    Route::get('carrito',                         [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('carrito/{vehiculo}',             [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('carrito/vaciar',               [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    Route::delete('carrito/{id}/eliminar',        [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('carrito/{id}/incrementar',       [CarritoController::class, 'incrementar'])->name('carrito.incrementar');
    Route::post('carrito/{id}/decrementar',       [CarritoController::class, 'decrementar'])->name('carrito.decrementar');
    Route::post('carrito/comprar',                [CarritoController::class, 'comprar'])->name('carrito.comprar');
});

Route::middleware('auth')->group(function () {
    Route::get('perfil',          [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('perfil/nombre',   [PerfilController::class, 'updateNombre'])->name('perfil.nombre');
    Route::put('perfil/password', [PerfilController::class, 'updatePassword'])->name('perfil.password');
});