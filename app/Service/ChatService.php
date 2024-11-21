<?php

namespace App\Services;

use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    // Método para enviar un mensaje
    public function enviarMensaje($idEmisor, $idRecibidor, $mensaje)
    {
        // Enviar el mensaje a través de WebSockets usando el canal de Broadcast
        Broadcast::channel('chat.' . $idRecibidor, [
            'id_emisor' => $idEmisor,
            'id_recibidor' => $idRecibidor,
            'mensaje' => $mensaje,
            'timestamp' => now(),
        ]);

        // Almacenar el mensaje en la base de datos NoSQL (MongoDB)
        return Chat::create([
            'id_emisor' => $idEmisor,
            'id_recibidor' => $idRecibidor,
            'mensaje' => $mensaje,
        ]);
    }

    // Método para filtrar mensajes según permisos y roles del usuario
    public function filtrarMensajes($userId)
    {
        $user = Auth::user();

        // Verificar si el usuario tiene el rol o permiso requerido
        if ($user->hasRole('admin')) {
            return Chat::all(); // Admin puede ver todos los mensajes
        } elseif ($user->hasRole('user')) {
            return Chat::where('id_recibidor', $userId)->get(); // Usuario estándar solo ve sus mensajes
        }

        return collect(); // Si no tiene permisos, devuelve colección vacía
    }
}
