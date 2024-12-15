<?php

namespace App\Http\Controllers;

use App\Exports\AsignacionExport;
use App\Http\Requests\Asignacion\StoreAsignacionRequest;
use App\Http\Requests\Asignacion\UpdateAsignacionRequest;
use App\Http\Requests\Proyecto\AsignarProyectoRequest;
use App\Models\Asignacion;
use App\Models\Estudiante;
use App\Models\Proyecto;
use App\Models\User;
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

    public function store(StoreAsignacionRequest $request)
    {
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

    public function eliminarEstudiante($proyectoId, $estudianteId)
    {
        // Buscar el proyecto y estudiante en la tabla pivot
        $proyecto = Proyecto::findOrFail($proyectoId);

        // Verificar si el estudiante está asociado al proyecto
        $proyecto->estudiantes()->detach($estudianteId);

        return back()->with('success', 'Estudiante eliminado del proyecto exitosamente.');
    }

    public function gestionActualizar(AsignarProyectoRequest $request, $id)
    {

        // Decodificar los estudiantes seleccionados desde el input JSON
        $estudiantesSeleccionados = json_decode($request->input('estudiantes'), true);

        // Validar que existan estudiantes seleccionados
        if (!$estudiantesSeleccionados || !is_array($estudiantesSeleccionados) || count($estudiantesSeleccionados) === 0) {
            return redirect()->back()->withErrors(['estudiantes' => 'Debe seleccionar al menos un estudiante.'])->withInput();
        }

        $tutor = User::find($request['idTutor'] ?? null);

        // Buscar el proyecto
        $proyecto = Proyecto::findOrFail($id);

        // Limpiar lista de estudiantes asociados al proyecto
        $proyecto->estudiantes()->detach();

        // Asociar los estudiantes seleccionados al proyecto
        foreach ($estudiantesSeleccionados as $estudianteId) {
            $estudiante = Estudiante::find($estudianteId);
            if ($estudiante) {
                $proyecto->estudiantes()->attach($estudiante->id_estudiante);
            }
        }

/////////////////////////////
        // Actualizar los datos del proyecto
        $proyecto->update([
            'tutor' => $tutor->id_usuario ?? null,
            'lugar' => $request['lugar'],
            'fecha_inicio' => $request['fecha_inicio'],
            'fecha_fin' => $request['fecha_fin'],
            'estado' => $request['estado'],
            'seccion_id' => $request['seccion_id'],
            'horas' => $request['horas'],
        ]);

        // Redirigir con éxito
        return redirect()->route('gestion-proyecto')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function asignarEstudiante(Request $request, $idProyecto)
    {
        // Buscar al estudiante por id
        $estudiante = Estudiante::find($request->idEstudiante);

        if (!$estudiante) {
            return back()->withErrors(['El estudiante no existe.']);
        }

        // Buscar el proyecto y asociar al estudiante
        $proyecto = Proyecto::findOrFail($idProyecto);
        // // Verificar si el estudiante ya está asignado
        if (!$proyecto->estudiantes->contains($estudiante->id_estudiante)) {
            $proyecto->estudiantes()->attach($estudiante->id_estudiante);
        } else {
            return back()->withErrors(['El estudiante ya está asignado a este proyecto.']);
        }

        return back()->with('success', 'Estudiante asignado correctamente.');
    }

    public function update(UpdateAsignacionRequest $request, $id)
    {
        $asignacion = Asignacion::findOrFail($id);

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
