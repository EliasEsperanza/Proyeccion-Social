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
        return view('notificaciones.index', compact('notificaciones'));
    }

    //Obtener una notificacion en especifico
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return view('notificaciones.show', compact('notification'));
    }

    //Form para crear una notificacion
    public function create()
    {
        return view('notificaciones.create');
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
        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada exitosamente');
    }

    //Form para Editar Notificacion
    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        return view('notificaciones.edit', compact('notification'));
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

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada exitosamente');
    }

    //Eliminar una notificacion
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada exitosamente');
    }
}

