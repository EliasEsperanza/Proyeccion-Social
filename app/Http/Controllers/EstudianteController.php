<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{

    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function getByUsuario($id_usuario)
    {
        $estudiantes = Estudiante::where('id_usuario', $id_usuario)->get();
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function getBySeccion($id_seccion)
    {
        $estudiantes = Estudiante::where('id_seccion', $id_seccion)->get();
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        return view('estudiantes.create');
    }

public function store(Request $request)
{
    $validatedData = $request->validate([
        'id_usuario' => 'required|integer',
        'id_seccion' => 'required|integer',
        'porcentaje_completado' => 'required|numeric|min:0|max:100',
        'horas_sociales_completadas' => 'required|integer|min:0',
    ]);

    Estudiante::create($validatedData);

    return redirect()->route('estudiantes.index');
}


    public function show(Estudiante $estudiante)
    {
        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante)
    {
        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'required|integer',
            'id_seccion' => 'required|integer',
            'porcentaje_completado' => 'required|numeric|min:0|max:100',
            'horas_sociales_completadas' => 'required|integer|min:0',
        ]);

        $estudiante->update($validatedData);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}
