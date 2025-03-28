<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;


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
        return redirect()->route('login');  // Ruta por defecto si el rol no está definido
    }
})->name('home');

// Rutas para Administrador
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index'); 
    })->name('admin.index');
   
       
    
    
});
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.user');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit'); 
    Route::put('/usuarios/{id}/update-role', [UserController::class, 'updateRole'])->name('usuarios.updateRole');
    Route::put('/reservas/{id}/finalizar', [ReservaController::class, 'finalizar'])->name('reservas.finalizar');

    Route::get('/admin/reservas', [ReservaController::class, 'listarReservas'])->name('admin.reservas');
});

// Rutas para Cliente
Route::middleware(['auth', 'role:Cliente'])->group(function () {
    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])->name('reservas.misReservas'); 
    Route::delete('/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
    Route::get('/reservas/{id}/edit', [ReservaController::class, 'edit'])->name('reservas.edit');
    Route::put('/reservas/{id}', [ReservaController::class, 'update'])->name('reservas.update');
    Route::put('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');

});

