<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\NotificacionController;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEstudiantes = app(EstudianteController::class)->totalEstudiantes();
        $totalProyectosActivos = app(ProyectoController::class)->totalProyectosActivos();
        $totalProyectosAsignados = app(ProyectoController::class)->totalProyectosAsignados(); 
        $totalTutores = app(UserController::class)->totalTutores();
        $totalCoordinadores = app(UserController::class)->totalCoordinadores();
        $notificaciones= app(NotificacionController::class)->getNotifiaciones(Auth::user()->id_usuario);
        return view('dashboard.dashboard', compact('totalEstudiantes', 'totalProyectosActivos', 'totalProyectosAsignados', 'totalTutores', 'totalCoordinadores','notificaciones'));
    }

    
}