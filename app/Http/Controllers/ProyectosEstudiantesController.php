<?php

namespace App\Http\Controllers;

use App\Models\ProyectosEstudiantes;
use Illuminate\Http\Request;

class ProyectosEstudiantesController extends Controller
{
    public function index()
    {
        $proyectos_estudiantes=ProyectosEstudiantes::all();
        return view('proyectos_estudiantes.index',compact('proyectos_estudiantes'));
    }

    public function getEstudiantesbyProyecto($id_proyectos){
        $proyectos_estudiantes=ProyectosEstudiantes::where('id_proyectos',$id_proyectos)->get();
        return view('proyectos_estudiantes.index',compact('proyectos_estudiantes'));
    }

    public function getProyectobyEstudiantes($id_estudiantes){
        $proyectos_estudiantes=ProyectosEstudiantes::where('id_estudiantes',$id_estudiantes)->get();
        return view('proyectos_estudiantes.index',compact('proyectos_estudiantes'));
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

        return redirect()->route('proyectos_estudiantes.index');
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
            return response()->json(['message' => 'Proyectos Estudiantes no encontrado'], 404);
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
            return response()->json(['message' => 'Proyectos Estudiantes no encontrado'], 404);
        }

        $proyectos_estudiantes->update($validacion);
        return response()->json($proyectos_estudiantes, 200);
    }


    public function destroy(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return response()->json(['message' => 'Proyectos Estudiantes no encontrado'], 404);
        }

        $proyectos_estudiantes->delete();
        return response()->json(['message' => 'Proyectos Estudiantes eliminado'], 200);

    }
}
