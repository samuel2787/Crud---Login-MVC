<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // crear usuario
    public function register(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'role' => 'required|in:admin,cliente',
        ]);

        User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => Hash::make($datos['password']),
            'role' => $datos['role'],
        ]);

        return response()->json(['mensaje' => 'Usuario creado']);
    }

    // iniciar sesión
    public function login(Request $request)
    {
        $credenciales = $request->only('email', 'password');

        if (! Auth::attempt($credenciales)) {
            return response()->json(['error' => 'Datos incorrectos'], 401);
        }

        $request->session()->regenerate(); // aquí "recuerda" al usuario

        return response()->json(['mensaje' => 'Login correcto']);
    }

    // cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['mensaje' => 'Sesión cerrada']);
    }

    // para que Vue sepa si hay sesión
    public function me()
    {
        return response()->json([
            'logueado' => Auth::check(),
            'role' => Auth::user()?->role,
        ]);
    }
}
