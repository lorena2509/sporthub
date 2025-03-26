<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::view('/', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->get('/home', function () {
    return view('home');
})->name('home');
