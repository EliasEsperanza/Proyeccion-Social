<?php

namespace App\Http\Controllers;

use App\Models\ProyectosEstudiantes;
use Illuminate\Http\Request;

class ProyectosEstudiantesController extends Controller
{
    public function index()
    {
        $proyectos_estudiantes = ProyectosEstudiantes::all();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }

    public function getEstudiantesbyProyecto($id_proyectos)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::where('id_proyectos', $id_proyectos)->get();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }

    public function getProyectobyEstudiantes($id_estudiantes)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::where('id_estudiantes', $id_estudiantes)->get();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }


    public function create()
    {
        return view("proyectos_estudiantes.create");
    }


    public function store(Request $request)
    {
        $validacion = $request->validate([
            'id_proyectos' => 'required|integer',
            'id_estudiantes' => 'required|integer',
        ]);

        ProyectosEstudiantes::create($validacion);

        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Asignacion de estudiante a proyecto exitosa');
    }


    public function show(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);
        return view('proyectos_estudiantes.show', compact('proyectos_estudiantes'));
    }

    public function edit(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }
        return view("proyectos_estudiantes.edit", compact('proyectos_estudiantes'));
    }


    public function update(Request $request, string $id)
    {
        $validacion = $request->validate([
            'id_proyectos' => 'required|integer',
            'id_estudiantes' => 'required|integer',
        ]);

        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }

        $proyectos_estudiantes->update($validacion);
        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Modificacion de asignacion de estudiante a proyecto exitosa');
    }


    public function destroy(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }

        $proyectos_estudiantes->delete();
        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Elminacion de asignacion de estudiante a proyecto exitosa');;
    }

    public function Detalles_proyecto()
    {
        $estudianteId = auth()->user()->id_estudiante;

        // prueba CON ID 3
        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', 2)
            ->with('proyecto')
            ->get()->first();


        if (!$proyectoEstudiante || !$proyectoEstudiante->proyecto) {
            return view('estudiantes.detallesmio')->withErrors('No tienes un proyecto asignado actualmente.');
        }

        $porcentaje = ($proyectoEstudiante->horas_sociales_completadas / $proyectoEstudiante->proyecto->horas_requeridas) * 100;
        //dd($proyectoEstudiante->horas_sociales_completadas);

        return view('estudiantes.detallesmio', compact('proyectoEstudiante', 'porcentaje'));
    }

    //retorna vista solicitud de proyecto
    public function Mi_proyecto()
    {
        $estudianteId = auth()->user()->id_estudiante;

        // prueba CON ID 3 
        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', 2)
            ->with('proyecto')
            ->get()->first();

        if (!$proyectoEstudiante || !$proyectoEstudiante->proyecto) {
            return view('estudiantes.detallesmio')->withErrors('No tienes un proyecto asignado actualmente.');
        }

        $porcentaje = ($proyectoEstudiante->horas_sociales_completadas / $proyectoEstudiante->proyecto->horas_requeridas) * 100;
        //dd($proyectoEstudiante->horas_sociales_completadas);

        return view('estudiantes.proyectomio', compact('proyectoEstudiante', 'porcentaje'));
    }

    public function Solicitud_Proyecto_Student()
    {
        return view('estudiantes.solicitud-proyecto');
    }

    public function Procesos()
    {
        return view('estudiantes.vista_procesos_horas');
    }

    public function docs()
    {
        return view('estudiantes.docs_tramites');
    }
}
