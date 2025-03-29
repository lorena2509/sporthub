<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CanchaController;

// Rutas de autenticación
Route::view('/', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Redirección después del login según el rol
Route::middleware('auth')->get('/home', function () {
    $user = Auth::user();

    if ($user->role_id == 1) { 
        return redirect()->route('admin.index');  // Ruta del menú para administradores
    } elseif ($user->role_id == 2) {
        return redirect()->route('reservas.index');  // Ruta del menú para clientes
    } else {
        return redirect('/')->with('error', 'Tu cuenta no tiene un rol válido.');
    }
})->name('home');

// Rutas protegidas para ADMINISTRADORES
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/admin', [CanchaController::class, 'index'])->name('admin.index');

    // CRUD de Canchas
    Route::get('/admin/canchas', [CanchaController::class, 'index'])->name('admin.canchas.index');
    Route::get('/admin/canchas/create', [CanchaController::class, 'create'])->name('admin.canchas.create');
    Route::post('/admin/canchas', [CanchaController::class, 'store'])->name('admin.canchas.store');
    Route::get('/admin/canchas/{id}/edit', [CanchaController::class, 'edit'])->name('admin.canchas.edit');
    Route::put('/admin/canchas/{id}', [CanchaController::class, 'update'])->name('admin.canchas.update');
    Route::delete('/admin/canchas/{id}', [CanchaController::class, 'destroy'])->name('admin.canchas.destroy');

    // Administración de usuarios y reservas
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.user');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit'); 
    Route::put('/usuarios/{id}/update-role', [UserController::class, 'updateRole'])->name('usuarios.updateRole');
    Route::get('/admin/reservas', [ReservaController::class, 'listarReservas'])->name('admin.reservas');
});

// Rutas protegidas para CLIENTES
Route::middleware(['auth', 'role:Cliente'])->group(function () {
    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])->name('reservas.misReservas'); 
    Route::delete('/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
    Route::get('/reservas/{id}/edit', [ReservaController::class, 'edit'])->name('reservas.edit');
    Route::put('/reservas/{id}', [ReservaController::class, 'update'])->name('reservas.update');
});
