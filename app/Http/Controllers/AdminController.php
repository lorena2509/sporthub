<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservaController;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
