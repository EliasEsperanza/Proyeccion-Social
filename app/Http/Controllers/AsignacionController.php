<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function index()
    {
        $asignaciones = Asignacion::all();
        return view('asignaciones.index', compact('asignaciones'));
    }

    public function create()
    {
        return view('asignaciones.create');
    }

    public function store(Request $request)
    {
        $asignacion = Asignacion::create($request->all());
        return redirect()->route('asignaciones.index')->with('success', 'Asignación creada con éxito');
    }

    public function show($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        return view('asignaciones.show', compact('asignacion'));
    }

    public function edit($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        return view('asignaciones.edit', compact('asignacion'));
    }

    public function update(Request $request, $id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $asignacion->update($request->all());
        return redirect()->route('asignaciones.index')->with('success', 'Asignación actualizada con éxito');
    }

    public function destroy($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $asignacion->delete();
        return redirect()->route('asignaciones.index')->with('success', 'Asignación eliminada con éxito');
    }
}
