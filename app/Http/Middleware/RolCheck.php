<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;

class RolCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $rol): Response
    {
        // Rutas a redirigir
        $roleRedirects = [
            'Estudiante' => 'estudiantes.dashboard',
            'Administrador' => 'dashboard',
            'Coordinador' => 'dashboard',
            'tutor' => 'dashboard',
        ];

        // Verifica rol
        if (!Auth::user()->hasRole($rol)) {
            foreach ($roleRedirects as $role => $route) {

                if (Auth::user()->hasRole($role)) {
                    return redirect()->route($route)->with('error', 'No tienes permiso para acceder a este contenido.');
                }
            }
        }

        return $next($request);
    }
}
