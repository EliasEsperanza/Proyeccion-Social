<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProyectoController;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEstudiantes = app(EstudianteController::class)->totalEstudiantes();
        $totalProyectosActivos = app(ProyectoController::class)->totalProyectosActivos();
        $totalTutores = app(UserController::class)->totalTutores();


        return view('dashboard.dashboard', compact('totalEstudiantes', 'totalProyectosActivos', 'totalTutores'));
    }

    
}