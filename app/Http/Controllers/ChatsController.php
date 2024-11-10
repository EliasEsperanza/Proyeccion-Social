<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function index()
    {
        return Chat::all();
    }

    // Crear un nuevo mensaje
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_emisor' => 'required|exists:users,id',
            'id_recibidor' => 'required|exists:users,id',
            'mensaje' => 'required|string|max:255',
        ]);

        $chat = Chat::create($validatedData);

        return response()->json($chat, 201);
    }

    // Mostrar mensajes de un usuario específico (por ejemplo, del recibidor)
    public function show($id)
    {
        $chats = Chat::where('id_recibidor', $id)->get();
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
