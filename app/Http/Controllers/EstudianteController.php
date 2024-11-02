<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ListEstudiantes = Estudiante::all();
        return view("estudiante.index", compact("ListEstudiantes")); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("estudiante.create"); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|integer|exists:users,id',
            'id_seccion' => 'required|integer|exists:secciones,id',
            'porcentaje_completado' => 'required|numeric|min:0|max:100',
            'horas_sociales_completadas' => 'required|integer|min:0'
        ]);

        Estudiante::create($data);

        return redirect()->route('estudiante.index')->with('success', 'Estudiante creado con éxito');  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiante.index')->with('error', 'Estudiante no encontrado');
        }

        return view("estudiante.show", compact('estudiante')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiante.index')->with('error', 'Estudiante no encontrado');
        }

        return view("estudiante.edit", compact('estudiante')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiante.index')->with('error', 'Estudiante no encontrado');
        }

        $data = $request->validate([
            'id_usuario' => 'required|integer|exists:users,id',
            'id_seccion' => 'required|integer|exists:secciones,id',
            'porcentaje_completado' => 'required|numeric|min:0|max:100',
            'horas_sociales_completadas' => 'required|integer|min:0'
        ]);

        $estudiante->update($data);

        return redirect()->route('estudiante.index')->with('success', 'Estudiante actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiante.index')->with('error', 'Estudiante no encontrado');
        }

        $estudiante->delete();

        return redirect()->route('estudiante.index')->with('success', 'Estudiante eliminado con éxito');
    }
}

