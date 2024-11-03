<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuditLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete')) {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Definir la acción en función del método HTTP
            $action = $request->isMethod('post') ? 'creado' : ($request->isMethod('put') ? 'actualizado' : 'eliminado');

            // Obtener el ID del documento (si está disponible en la ruta o en el objeto de respuesta)
            $documentoId = $request->route('documento') ?? ($response->original->id ?? 'desconocido');

            // Registrar la acción en los logs
            Log::info("Documento {$action}: ID {$documentoId} por usuario ID {$user->id}");
        }

        return $response;
    }
}
