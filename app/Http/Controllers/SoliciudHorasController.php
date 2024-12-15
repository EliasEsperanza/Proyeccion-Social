<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\HistoriaHorasActualizada;
use App\Models\Proyecto;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;

class SoliciudHorasController extends Controller
{
//donde se usa?
    public function revisarSolicitud(Request $request, $id)
    {
        $user = auth()->user();

        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', $user->id_usuario)->first();
        $proyecto = Proyecto::find($proyectoEstudiante->id_proyecto);
        $horas = Estudiante::where('id_estudiante', $user->id_usuario)->first();

        return view('estudiantes.actualizar-horas')->with([
            'proyecto' => $proyecto,
            'horas' => $horas,
        ]);
    }
    //to service

    public function mostrarSolicitud(string $id, string $solicitudId)
    {

        $solicitud = Solicitud::find($solicitudId);

        if (!$solicitud) {
            return redirect()->route('proyecto-g')->with('error', 'Solicitud no encontrada');
        }

        $proyecto = Proyecto::find($solicitud->id_proyecto);

        if (!$proyecto) {
            return redirect()->route('proyecto-g')->with('error', 'Proyecto asociado no encontrado');
        }

        $estudiante = Estudiante::find($solicitud->id_estudiante);

        if (!$estudiante) {
            return redirect()->route('proyecto-g')->with('error', 'Estudiante asociado no encontrado');
        }

        $usuario = User::find($estudiante->id_usuario);

        if (!$usuario) {
            return redirect()->route('proyecto-g')->with('error', 'Usuario asociado al estudiante no encontrado');
        }
        $rutaDocs = 'storage/solicitudes/';
        return view('proyecto.proyecto-solicitudes-revision', compact('solicitud', 'proyecto', 'usuario', 'estudiante', 'rutaDocs'));
    }
    
    //to service

    public function solicitudes_avance_horas(string $id)
    {
        $id = (int)$id;

        $solicitudes = Solicitud::where('id_proyecto', $id)->get();
        $proyecto = Proyecto::find($id);
        foreach ($solicitudes as $solicitud) {
            $estudiante = Estudiante::where('id_estudiante', $solicitud->id_estudiante)->first();
            $solicitud->nombre = User::find($estudiante->id_usuario)->name;
            //nombre del usuario asociado al id de estudiante
        }

        //dd($id,'soli', $solicitudes);
        $estados = Estado::all();

        return view('proyecto.proyecto-solicitudes', compact('solicitudes', 'proyecto', 'estados'));
    }
    //to service

    public function aprobarSolicitud(string $id, string $solicitudId)
    {
        $solicitud = Solicitud::find($solicitudId);
        //dd($solicitud);
        if (!$solicitud) {
            return redirect()->route('proyecto-g')->with('error', 'Solicitud no encontrada');
        }

        $proyecto = Proyecto::find($solicitud->id_proyecto);
        if (!$proyecto) {
            return redirect()->route('proyecto-g')->with('error', 'Proyecto no encontrado');
        }

        $estudiante = Estudiante::where('id_estudiante', $solicitud->id_estudiante)->first();
        if (!$estudiante) {
            return redirect()->route('proyecto-g')->with('error', 'Estudiante no encontrado');
        }

        // Calcular el nuevo porcentaje de progreso del estudiante
        $porcentajeNuevo = $proyecto->horas_requeridas > 0
            ? round((($estudiante->horas_sociales_completadas + $solicitud->valor) / $proyecto->horas_requeridas) * 100, 2)
            : 0;

        // Actualizar las horas sociales completadas y el porcentaje
        $estudiante->horas_sociales_completadas += $solicitud->valor;
        $estudiante->porcentaje_completado = $porcentajeNuevo; // Asegúrate de que esté actualizando correctamente

        // Actualizar el estado de la solicitud
        $solicitud->estado = 10;
        $solicitud->save();

        // Guardar los cambios en Estudiante y Solicitud
        $estudiante->save();

        // Guardar la información de horas aceptadas en la tabla de historial
        HistoriaHorasActualizada::create([
            'id_estudiante' => $estudiante->id_estudiante,
            'id_solicitud' => $solicitud->solicitud_id,
            'id_proyecto' => $proyecto->id_proyecto,  // Registrar el id del proyecto
            'horas_aceptadas' => $solicitud->valor, // Horas aceptadas
            'fecha_aceptacion' => now(), // Fecha de aceptación
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('solicitudes_avance_horas', [
            'id' => $proyecto->id_proyecto
        ])->with('success', 'Solicitud aprobada y horas registradas correctamente');
    }
    public function denegarSolicitud(string $id, string $solicitudId)
    {
        $solicitud = Solicitud::find($solicitudId);
        $proyecto = Proyecto::find($solicitud->id_proyecto);
        $estudiante = Estudiante::where('id_estudiante', $solicitud->id_estudiante)->first();
        $usuario = User
        +::find($estudiante->id_usuario);

        if (!$solicitud) {
            return redirect()->route('proyecto-g')->with('error', 'Solicitud no encontrada');
        }

        $solicitud->estado = 7;

        $solicitud->save();

        return redirect()->route('solicitudesProyectos', [
            'id' => $proyecto->id_proyecto
        ])->with('success', 'Solicitud rechazada correctamente');
    }



    /*public function aprobarSolicitud(string $id, string $solicitudId)
    {
        $solicitud = Solicitud::find($solicitudId);
        if (!$solicitud) {
            return redirect()->route('proyecto-g')->with('error', 'Solicitud no encontrada');
        }

        $proyecto = Proyecto::find($solicitud->id_proyecto);

        $proyecto = Proyecto::find($solicitud->id_proyecto);
        if (!$proyecto) {
            return redirect()->route('proyecto-g')->with('error', 'Proyecto no encontrado');
        }

        $estudiante = Estudiante::where('id_estudiante', $solicitud->id_estudiante)->first();
        if (!$estudiante) {
            return redirect()->route('proyecto-g')->with('error', 'Estudiante no encontrado');
        }

        $usuario = User::find($estudiante->id_usuario);

        $porcentajeNuevo = $proyecto->horas_requeridas > 0
            ? round((($estudiante->horas_sociales_completadas + $solicitud->valor) / $proyecto->horas_requeridas) * 100, 2)
            : 0;

        $estudiante->horas_sociales_completadas += $solicitud->valor;
        $estudiante->porcentaje_completado += $porcentajeNuevo;

        $solicitud->estado = 10;

        $estudiante->save();
        $solicitud->save();

        return redirect()->route('solicitudesProyectos', [
            'id' => $proyecto->id_proyecto
        ])->with('success', 'Solicitud aprobada correctamente');
    }*/
}
