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
        // Comprobamos los parámetros de la solicitud
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            if (is_string($value) && $this->containsMaliciousSQL($value)) {
                return redirect()->route('login.malisioso')->with('error', 'Entrada inválida, cuidadito');
            }
        }

        return $response;
    }


    /**
     * Detecta patrones de SQL maliciosos en una cadena
     *
     * @param string $value
     * @return bool
     */
    protected function containsMaliciousSQL(string $value): bool
    {
        $patterns = [
            '/(\b(UNION|DROP|ALTER|INSERT|DELETE|UPDATE|SELECT)\b.+?(FROM|INTO))/i',
            '/(--|\/\*|\*\/|;)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }

        return false;
    }
}
