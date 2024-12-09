<?php

namespace App\Http\Controllers;

use App\Exports\AsignacionExport;
use App\Models\Asignacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AsignacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Asignacion::query();

        // Busqueda y filtrado por Id y fecha de asignación
        if ($request->has('id_asignacion')) {
            $idAsignacion = $request->input('id_asignacion');
            $query->where('id_asignacion', $idAsignacion);
        }

        if ($request->has('fecha_asignacion')) {
            $fechaAsignacion = $request->input('fecha_asignacion');
            $query->where('fecha_asignacion', $fechaAsignacion);
        }

        //Paginacion para mostrar 10 resultados por pagina
        $asignaciones = Asignacion::paginate(10);

        return view('asignaciones.index', compact('asignaciones'));
    }

    public function create()
    {
        return view('asignaciones.create');
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'id_proyecto' => 'required|integer|min:1',
            'id_estudiante' => 'required|integer|min:1',
            'id_tutor' => 'required|integer|min:1',
            'fecha_asignacion' => 'required|date|after_or_equal:today',
        ], [
            'id_proyecto.required' => 'El proyecto es obligatorio.',
            'id_estudiante.required' => 'El estudiante es obligatorio.',
            'id_tutor.required' => 'El tutor es obligatorio.',
            'fecha_asignacion.required' => 'La fecha de asignación es obligatoria.',
            'fecha_asignacion.after_or_equal' => 'La fecha debe ser hoy o posterior.',
        ]);

        try {

            Asignacion::create($request->all());
            return redirect()->route('asignaciones.index')->with('success', 'Asignación creada con éxito');
        } catch (\Exception $e) {
            // Manejo de errores en caso de fallo
            return redirect()->back()
                ->withInput()
                ->with('error', 'Hubo un problema al crear la asignación.');
        }
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

        // Validar datos al actualizar
        $request->validate([
            'id_proyecto' => 'sometimes|integer|min:1',
            'id_estudiante' => 'sometimes|integer|min:1',
            'id_tutor' => 'sometimes|integer|min:1',
            'fecha_asignacion' => 'sometimes|date|after_or_equal:today',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'after_or_equal' => 'La fecha de asignación debe ser hoy o una fecha futura.',
        ], [
            'id_proyecto' => 'proyecto',
            'id_estudiante' => 'estudiante',
            'id_tutor' => 'tutor',
            'fecha_asignacion' => 'fecha de asignación',
        ]);

        try {
            $asignacion->update($request);

            return redirect()->route('asignaciones.index')->with('success', 'Asignación actualizada con éxito');
        } catch (\Exception $e) {
            // Redirigir con mensaje de error en caso de fallo
            return redirect()->route('asignaciones.index')->with('error', 'Error al actualizar la asignación.');
        }
    }

    public function destroy($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $asignacion->delete();
        return redirect()->route('asignaciones.index')->with('success', 'Asignación eliminada con éxito');
    }

    public function exportExcel()
    {
        return Excel::download(new AsignacionExport, 'asignaciones.xlsx');
    }

    public function exportPDF()
    {
        $asignaciones = Asignacion::all();

        $pdf = Pdf::loadView('exports.asignacionesPDF', ['asignaciones' => $asignaciones]);

        return $pdf->download('asignaciones.pdf');
    }
}
