<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Intentamos obtener el usuario autenticado con el token JWT
            $user = JWTAuth::parseToken()->authenticate();
            
            // Si no se encuentra un usuario (token inválido o expirado), redirigimos al home 
            if (!$user) {
                return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
            }

        } catch (JWTException $e) {
            return redirect()->route('home')->with('error', 'Token inválido o expirado.');
        }

        // Si la autenticación fue exitosa
        return $next($request);
    }
}