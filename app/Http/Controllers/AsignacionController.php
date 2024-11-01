<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function index()
    {
        $asignaciones = Asignacion::all();
        return response()->json($asignaciones);
    }

    public function store(Request $request)
    {
        $asignacion = Asignacion::create($request->all());
        return response()->json($asignacion, 201);
    }

    public function show($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        return response()->json($asignacion);
    }

    public function update(Request $request, $id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $asignacion->update($request->all());
        return response()->json($asignacion);
    }

    public function destroy($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $asignacion->delete();
        return response()->json(null, 204);
    }
}
