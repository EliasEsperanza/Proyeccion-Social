<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    //Obtener las notificaciones
    public function index($userId)
    {
        $notifications = Notification::where('id_usuario', $userId)->get();
        return response()->json($notifications);
    }

    //Obtener una notificacion en especifico
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    //Crear una nueva notificacion
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'mensaje' => 'required|string',
            'estado' => 'required|string',
            'fecha_envio' => 'required|date',
        ]);

        $notification = Notification::create($request->all());
        return response()->json($notification, 201);
    }

    //Actualizar una notificacion
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_usuario' => 'sometimes|exists:usuarios,id',
            'mensaje' => 'sometimes|string',
            'estado' => 'sometimes|string',
            'fecha_envio' => 'sometimes|date',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->update($request->all());

        return response()->json(['message' => 'Notificación actualizada', 'data' => $notification]);
    }

    //Eliminar una notificacion
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notificación eliminada']);
    }
}

