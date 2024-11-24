<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{

    //Obtener las notificaciones
    public function getNotifiaciones($userId)
    {
        $notifications = Notificacion::where('id_usuario', $userId)->orderBy('fecha_envio','desc')->take(5)->get();
       return $notifications;
    }

    public function enviarNotificacion($idUser,$mensaje){
       
        Notificacion::create([
            'id_usuario' => $idUser,
            'mensaje' => $mensaje,
            'estado' => 'Enviado Correctamente',
            'fecha_envio' => now()->toDateString()
        ]);
    }

    
}

