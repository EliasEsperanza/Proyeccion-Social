<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    // Mostrar todos los mensajes
    public function index()
    {
        // Usa el servicio para filtrar mensajes basados en el usuario autenticado
        $mensajes = $this->chatService->filtrarMensajes(auth()->id());
        return response()->json($mensajes);
    }

    // Crear un nuevo mensaje
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_emisor' => 'required|exists:users,id',
            'id_recibidor' => 'required|exists:users,id',
            'mensaje' => 'required|string|max:255',
        ]);

        // Usa el servicio para enviar y almacenar el mensaje
        $chat = $this->chatService->enviarMensaje(
            $validatedData['id_emisor'],
            $validatedData['id_recibidor'],
            $validatedData['mensaje']
        );

        return response()->json($chat, 201);
    }

    // Mostrar mensajes de un usuario específico (por ejemplo, del recibidor)
    public function show($id)
    {
        // Usa el servicio para filtrar mensajes para el recibidor específico
        $chats = $this->chatService->filtrarMensajes($id);
        return response()->json($chats);
    }

    // Eliminar un mensaje (si se permite en la lógica de la aplicación)
    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();

        return response()->json(['message' => 'Mensaje eliminado exitosamente.']);
    }
}
