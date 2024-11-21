<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class registerYloginController extends Controller
{
    
    public function register(RegisterRequest $request)
    {
       
        $validated = $request->validated();

       
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        
        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente. Ahora puedes iniciar sesión.');
    }

    
    public function login(LoginRequest $request)
    {
        
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
          
            return redirect()->route('dashboard')->with('success', 'Inicio de sesión exitoso.');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->withInput();
    }

    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente.');
    }
}
