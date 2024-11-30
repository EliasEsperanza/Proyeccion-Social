<?php

namespace App\Http\Controllers;

use App\Models\HistoriaHorasActualizada;
use App\Models\Proyecto;
use App\Models\ProyectosEstudiantes;
use Illuminate\Http\Request;

class HistoriaHorasActualizadaController extends Controller
{
    public function index()
    {
        $historias = HistoriaHorasActualizada::all();
        return view('historias_horas_actualizadas.index', compact('historias'));
    }

    public function create()
    {
        return view('historias_horas_actualizadas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id_estudiante',
            'id_solicitud' => 'required|exists:solicitudes,solicitud_id',
        ]);

        HistoriaHorasActualizada::create($request->all());
        return redirect()->route('historias_horas_actualizadas.index')->with('success', 'Registro creado con éxito.');
    }

    public function show($id)
    {
        $historia = HistoriaHorasActualizada::findOrFail($id);
        return view('historias_horas_actualizadas.show', compact('historia'));
    }

    public function edit($id)
    {
        $historia = HistoriaHorasActualizada::findOrFail($id);
        return view('historias_horas_actualizadas.edit', compact('historia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id_estudiante',
            'id_solicitud' => 'required|exists:solicitudes,solicitud_id',
        ]);

        $historia = HistoriaHorasActualizada::findOrFail($id);
        $historia->update($request->all());
        return redirect()->route('historias_horas_actualizadas.index')->with('success', 'Registro actualizado con éxito.');
    }

    public function destroy($id)
    {
        $historia = HistoriaHorasActualizada::findOrFail($id);
        $historia->delete();
        return redirect()->route('historias_horas_actualizadas.index')->with('success', 'Registro eliminado con éxito.');
    }

    public function historial($id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return redirect()->route('proyectos.index')->with('error', 'Proyecto no encontrado.');
        }

        $historial = HistoriaHorasActualizada::where('id_proyecto', $id)->get();

        return view('proyectos.detallesmio', compact('proyecto', 'historial'));
    }
    public function aceptarHoras(Request $request)
    {
        // Valida que los datos necesarios estén presentes
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id_estudiante',
            'id_solicitud' => 'required|exists:solicitudes,solicitud_id',
            'horas_aceptadas' => 'required|numeric|min:0', // Asegúrate de que sea un valor numérico
            'fecha_aceptacion' => 'required|date',
        ]);

        // Guarda las horas aceptadas y la fecha en la tabla de historial
        HistoriaHorasActualizada::create([
            'id_estudiante' => $request->id_estudiante,
            'id_solicitud' => $request->id_solicitud,
            'horas_aceptadas' => $request->horas_aceptadas,
            'fecha_aceptacion' => $request->fecha_aceptacion,
        ]);

        // Retorna una respuesta o redirige según lo necesario
        return redirect()->route('ruta.donde.redirigir')
                        ->with('success', 'Horas aceptadas y registradas correctamente.');
    }

}
