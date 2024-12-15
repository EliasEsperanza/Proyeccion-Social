<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyecto\StoreSolicitudRequest;
use App\Models\Estudiante;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class SolicitudProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    //to service

    private function actualizarEstadoSolicitud($id_proyecto, $nuevoEstado, $mensaje)
    {
        $proyecto = Proyecto::where('id_proyecto', $id_proyecto)->first();

        if ($proyecto) {
            $proyecto->estado = $nuevoEstado;
            $proyecto->save();

            return redirect()->route('solicitudes_coordinador')
                ->with('success', $mensaje);
        } else {

            return redirect()->route('solicitudes_coordinador')
                ->with('error', 'El proyecto no fue encontrado.');
        }
    }

    public function solicitudes_coordinador()
    {
        $proyectos = Proyecto::with('estudiantes.usuario')

            ->where('estado', 9)
            ->get();
        return view('proyecto.solicitud-proyecto-coordinador', compact('proyectos'));
    }

    //to service
    //aceptar solucitud
    public function aceptarSolicitud($id_proyecto)
    {
        $proyecto = Proyecto::find($id_proyecto);
        $estudiantes = $proyecto->estudiantes;
        foreach ($estudiantes as $estu) {
            $id = $estu->usuario->id_usuario;

            app(NotificacionController::class)->enviarNotificacion($id, 'Has sido aprobado en el proyecto ' . $proyecto->nombre_proyecto);
        }
        return $this->actualizarEstadoSolicitud($id_proyecto, 1, 'El proyecto ha sido aceptado exitosamente.');
    }
    //to service

    public function rechazarSolicitud($id_proyecto)
    {
        $objProyecto_Estudiante = new ProyectosEstudiantesController();
        $proyecto = Proyecto::find($id_proyecto);
        $estudiantes = $proyecto->estudiantes;
        foreach ($estudiantes as $estu) {
            $id = $estu->usuario->id_usuario;
            $objProyecto_Estudiante->Rechazar_solicitus_destroy($id_proyecto);
            app(NotificacionController::class)->enviarNotificacion($id, 'Has sido rechazado en el proyecto ' . $proyecto->nombre_proyecto);
        }
        return $this->actualizarEstadoSolicitud($id_proyecto, 7, 'El proyecto ha sido rechazado exitosamente.');
    }

    //to service

    public function store_solicitud_alumno(Request $request)
    {

        $estudiantesSeleccionados = json_decode($request->input('estudiantesSeleccionados'), true);
        $proyecto = Proyecto::find($request->input('id_proyecto'));

        // Verificar si $estudiantesSeleccionados es un array
        if (is_array($estudiantesSeleccionados)) {

            $estudianteNotificacion = Estudiante::find($estudiantesSeleccionados[0]);
            $idCoordinador = $estudianteNotificacion->seccion->id_coordinador;

            app(NotificacionController::class)->enviarNotificacion(
                $idCoordinador,
                'Hay una nueva aplicación al proyecto ' . $proyecto->nombre_proyecto
            );

            foreach ($estudiantesSeleccionados as $idEstudiante) {
                $estudiante = Estudiante::find($idEstudiante);

                // Verificar si $estudiante fue encontrado
                if ($estudiante) {
                    // Verificar si la relación entre proyecto y estudiante ya existe
                    $existeRelacion = $proyecto->estudiantes()
                        ->where('proyectos_estudiantes.id_estudiante', $estudiante->id_estudiante) // Especificar la tabla
                        ->exists();

                    if (!$existeRelacion) {
                        $proyecto->estudiantes()->attach($estudiante->id_estudiante);
                    } else {

                        return redirect()->back()->with(
                            'warning',
                            "El estudiante con ID {$estudiante->id_estudiante} ya está asociado al proyecto."
                        );
                    }
                } else {
                }
            }
        } else {
        }

        return redirect()->back()->with('success', 'Proyecto creado exitosamente.');
    }
    //to service

    public function store_solicitud(StoreSolicitudRequest $request)
    {
        $estudiantesSeleccionados = json_decode($request->input('estudiantes'), true);

        try {
            // Crear el proyecto
            $proyecto = Proyecto::create([
                'nombre_proyecto' => $request['nombre_proyecto'],
                'descripcion_proyecto' => strip_tags($request['descripcion']),
                'lugar' => $request['lugar'],
                'estado' => 9, // Estado inicial de solicitud
                'horas_requeridas' => 0, // Inicialmente en 0
                'periodo' => now()->format('Y-m'),
                'coordinador' => auth()->id(),
                'seccion_id' => $request['id_seccion'],
                'fecha_inicio' => $request['fecha_inicio'],
                'fecha_fin' => $request['fecha_fin'],
            ]);

            // Asociar estudiantes al proyecto
            if (is_array($estudiantesSeleccionados)) {
                $estudianteNotificacion = Estudiante::find($estudiantesSeleccionados[0]);
                $idCoordinador = $estudianteNotificacion->seccion->id_coordinador;

                app(NotificacionController::class)->enviarNotificacion(
                    $idCoordinador,
                    'Se ha solicitado la aprobación del proyecto ' . $request['nombre_proyecto']
                );

                foreach ($estudiantesSeleccionados as $idEstudiante) {
                    $estudiante = Estudiante::find($idEstudiante);

                    if ($estudiante) {
                        $proyecto->estudiantes()->attach($estudiante->id_estudiante);
                    }
                }
            }

            // Redirigir con mensaje de éxito
            return redirect()->route('estudiantes.dashboard')->with('success', 'Proyecto creado exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al crear el proyecto: ' . $e->getMessage());

            // Redirigir con mensaje de error
            return redirect()->back()->withInput()->with('error', 'Hubo un error al crear el proyecto.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
