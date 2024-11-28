<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest; // Importa el Request para registro
use App\Models\User; // Importa el modelo User para interactuar con la base de datos
use Illuminate\Support\Facades\Auth; // Para gestionar la autenticación
use Illuminate\Support\Facades\Hash; // Para el hashing de contraseñas
use Illuminate\Http\Request;

class RegisterYLoginController extends Controller
{
    public function __construct()
    {
        // Asegura que los usuarios autenticados no accedan al formulario de login
        $this->middleware('guest')->except('logout');
        // Aplica el middleware para la validación del login en el método de login
        $this->middleware('validacionLoginContraseña')->only('login');
    }

    /**
     * Muestra el formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa el login después de que el middleware haya validado la contraseña
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Si la autenticación es exitosa, redirigir al dashboard o página de destino
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('success', 'Inicio de sesión exitoso.');
        }

        // Si llega aquí, la autenticación ha fallado, redirigir con errores
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
    }

    /**
     * Registra un nuevo usuario
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        // Validación de los datos del request
        $validated = $request->validated();

        // Crear un nuevo usuario en la base de datos
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Se guarda la contraseña de manera segura
        ]);

        // Redirige al login con un mensaje de éxito
        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente. Ahora puedes iniciar sesión.');
    }

    /**
     * Método para hacer logout
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente.');
    }
}
