<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'document' => 'required|string|unique:users',
            'phonenumber' => 'required|string',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'document' => $request->document,
            'phonenumber' => $request->phonenumber,
            'role_id' => 2  // Rol por defecto (por ejemplo, "Usuario")
        ]);
    
        return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión.');
    }
    

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->with('error', 'Credenciales incorrectas.');
    }

    $user = Auth::user();

    // Redirigir según el rol del usuario
    if ($user->role_id == 1) { 
        return redirect()->route('admin.index');  // Ruta del menú para administradores
    } elseif ($user->role_id == 2) {
        return redirect()->route('reservas.index');  // Ruta del menú para clientes
    } else {
        return redirect()->route('login');  // Ruta por defecto si el rol no está definido
    }
}


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
