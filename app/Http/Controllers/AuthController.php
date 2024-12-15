<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Método de registro
    public function register(RegisterRequest $request)
    {
        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'Estudiante' // Asignación de rol predeterminado
        ]);

        // Generar token
        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    // Método de inicio de sesión
    public function login(Request $request)
    {
        // Validar los datos
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return response()->json(['token' => $token]);
    }

    // Método de cierre de sesión
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    // Método de renovación de token
    public function refresh()
    {
        return response()->json(['token' => Auth::refresh()]);
    }
    public function Identificador()
    {
        $user = Auth::User();
        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }
        return response()->json(['id_usuario' => $user]);
    }
}