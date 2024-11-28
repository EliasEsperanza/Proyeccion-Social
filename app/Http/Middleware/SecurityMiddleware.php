<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        // Prevenir inyecciones SQL
        foreach ($request->all() as $key => $value) {
            if (is_string($value) && preg_match('/(\b(SELECT|INSERT|DELETE|UPDATE|DROP|ALTER)\b|--|\/\*|\*\/|;)/i', $value)) {
                abort(400, "Entrada inválida detectada en el campo '{$key}'.");
            }
        }

        return $response;
    }
}

