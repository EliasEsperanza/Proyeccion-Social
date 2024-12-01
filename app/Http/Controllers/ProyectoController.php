<?php

namespace App\Http\Controllers;



use App\Models\ProyectosEstudiantes;
use App\Models\HistoriaHorasActualizada;
use App\Models\Proyecto;
use App\Models\Seccion;
use App\Models\Estudiante;
use App\Models\Estado;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Departamento;
use App\Models\Asignacion;
use App\Exports\ProyectosExport;
use App\Models\Solicitud;
use Illuminate\Container\Attributes\DB as AttributesDB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\NotificacionController;

class ProyectoController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Usuario autenticado

        if ($user->hasRole('Tutor')) {
            // Filtrar proyectos asignados al tutor autenticado mediante la tabla asignaciones
            $ListProyecto = Proyecto::with([
                'seccion.departamento',
                'estudiantes',
                'coordinadorr',
                'tutorr.seccionesTutoreadas',
                'estadoo'
            ])
                ->whereHas('asignaciones', function ($query) use ($user) {
                    $query->where('id_tutor', $user->id_usuario);
                })
                ->whereHas('estadoo', function ($query) {
                    $query->where('nombre_estado', '!=', 'Disponible')
                        ->where('nombre_estado', '!=', 'Solicitud');
                })
                ->get();
        } else {
            // Mostrar todos los proyectos para roles diferentes a tutor
            $ListProyecto = Proyecto::with([
                'seccion.departamento',
                'estudiantes',
                'coordinadorr',
                'tutorr.seccionesTutoreadas',
                'estadoo'
            ])
                ->whereHas('estadoo', function ($query) {
                    $query->where('nombre_estado', '!=', 'Disponible')
                        ->where('nombre_estado', '!=', 'Solicitud');
                })
                ->get();
        }

        return view("proyecto.proyecto-general", compact("ListProyecto"));
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_proyecto', 'id_proyecto');
    }


    public function store_solicitud(Request $request)
    {
        $estudiantesSeleccionados = json_decode($request->input('estudiantes'), true);

        $validatedData = $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'lugar' => 'required|string|max:255',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'id_seccion' => 'required|integer|exists:secciones,id_seccion',
            'estudiantes' => 'required|string',
        ]);

        try {
            // Crear el proyecto
            $proyecto = Proyecto::create([
                'nombre_proyecto' => $validatedData['nombre_proyecto'],
                'descripcion_proyecto' => strip_tags($validatedData['descripcion']),
                'lugar' => $validatedData['lugar'],
                'estado' => 9, // Estado inicial de solicitud
                'horas_requeridas' => 0, // Inicialmente en 0
                'periodo' => now()->format('Y-m'),
                'coordinador' => auth()->id(),
                'seccion_id' => $validatedData['id_seccion'],
                'fecha_inicio' => $validatedData['fecha_inicio'],
                'fecha_fin' => $validatedData['fecha_fin'],
            ]);

            // Asociar estudiantes al proyecto
            if (is_array($estudiantesSeleccionados)) {
                $estudianteNotificacion = Estudiante::find($estudiantesSeleccionados[0]);
                $idCoordinador = $estudianteNotificacion->seccion->id_coordinador;

                app(NotificacionController::class)->enviarNotificacion(
                    $idCoordinador,
                    'Se ha solicitado la aprobación del proyecto ' . $validatedData['nombre_proyecto']
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


    //agregar id de estudiantes a un proyecto en fase de solicitud
    public function store_solicitud_alumno(Request $request)
    {


        try {
            $estudiantesSeleccionados = json_decode($request->input('estudiantesSeleccionados'), true);
            $proyecto = Proyecto::find($request->input('id_proyecto'));
            if (is_array($estudiantesSeleccionados)) {
                $estudianteNotificacion = Estudiante::find($estudiantesSeleccionados[0]);
                $idCoordinador = $estudianteNotificacion->seccion->id_coordinador;

                app(NotificacionController::class)->enviarNotificacion($idCoordinador, 'Hay una nueva aplicacion al proyecto ' . $proyecto->nombre_proyecto);
                foreach ($estudiantesSeleccionados as $idEstudiante) {
                    $estudiante = Estudiante::find($idEstudiante);
                    if ($estudiante) {
                        // evitar que se aplique al mismo proyecto mas de una vez
                        $existeRelacion = $proyecto->estudiantes()
                            ->where('id_estudiante', $estudiante->id_estudiante)
                            ->exists();

                        if (!$existeRelacion) {
                            $proyecto->estudiantes()->attach($estudiante->id_estudiante);
                        } else {
                            return redirect()->back()->with('warning', 'El estudiante con Due {$estudiante->id_estudiante} ya está asociado al proyecto.');
                        }
                    }
                }
            }

            return redirect()->back()->with('success', 'Proyecto creado exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al crear el proyecto: ' . $e->getMessage());
            \Log::error('Código de error: ' . $e->getCode());
            return redirect()->back()->withInput()->with('error', 'Hubo un error al crear el proyecto. Por favor, inténtalo de nuevo más tarde.');
        }
    }

    public function solicitudes_coordinador()
    {
        $proyectos = Proyecto::with('estudiantes.usuario')

            ->where('estado', 9)
            ->get();
        return view('proyecto.solicitud-proyecto-coordinador', compact('proyectos'));
    }

    public function retornar_proyectos()
    {
        $proyectos = Proyecto::with('seccion.departamento', 'estudiantes', 'coordinadorr', 'tutorr.seccionesTutoreadas', 'estadoo')->get();
        //dd($ListProyecto);
        return view("proyecto.proyecto-disponible", compact("proyectos"));
        /*
        $proyectos = Proyecto::with(['seccion.departamento'])->get();
        return view("proyecto.proyecto-disponible", compact("proyectos"));
        */
    }

    public function create()
    {
        return view("Proyecto.createProyecto");
    }

    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255|regex:/^\S.*$/', // No permite espacios al inicio
            'descripcion' => 'required|string|min:10|max:1000', // Longitud mínima y máxima
            'horas' => 'required|integer|min:1|max:500', // Número válido
            'ubicacion' => 'required|string|max:255|regex:/^\S.*$/', // No permite espacios al inicio
            'id_seccion' => 'required|exists:secciones,id_seccion', // Debe existir en la tabla 'secciones'
        ]); 
    

        try {
            // Crear proyecto 
            $proyecto = new Proyecto();
            $proyecto->nombre_proyecto = htmlspecialchars($validatedData['titulo'], ENT_QUOTES, 'UTF-8'); // XSS es importante aquí para evitar inyección de scripts
            $proyecto->descripcion_proyecto = strip_tags($validatedData['descripcion'], '<p><a><ul><li><ol><strong><em>');
            $proyecto->horas_requeridas = $validatedData['horas'];
            $proyecto->lugar = htmlspecialchars($validatedData['ubicacion'], ENT_QUOTES, 'UTF-8');
            $proyecto->estado = 1;
            $proyecto->periodo = now()->format('Y-m');
            $proyecto->coordinador = auth()->id();  // Coordinador actual
            $proyecto->seccion_id = $validatedData['id_seccion'];
            $proyecto->fecha_inicio = now();
            $proyecto->fecha_fin = now()->addMonths(3);

            // Validar lógica de fechas
            if ($proyecto->fecha_fin <= $proyecto->fecha_inicio) {  // Fecha de finalización debe ser posterior a la de inicio 
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'La fecha de finalización debe ser posterior a la fecha de inicio.');
            }


            $proyecto->save();


            return redirect()
                ->back()
                ->with('success', "El proyecto '{$proyecto->nombre_proyecto}' ha sido creado exitosamente.");
        } catch (\Exception $e) {
            // Loggear error
            \Log::error('Error al crear proyecto', [
                'usuario' => auth()->id(),
                'datos' => $validatedData,
                'error' => $e->getMessage(),
            ]);

            // Mensaje de error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el proyecto. Por favor intente nuevamente.');
        }
    }

    public function show(string $id)
    {
        $proyecto = Proyecto::find($id);
        return view('Proyecto.showProyecto', compact('proyecto'));
    }

    public function edit(string $id)
    {
        $proyecto = Proyecto::find($id);
        $estados = Estado::all();
        $estudiantes = Estudiante::all();
        $secciones = Seccion::all();
        $tutores = User::role('tutor')
            ->whereHas('seccionesTutoreadas')
            ->with('seccionesTutoreadas')
            ->get();
        if (!$proyecto) {
            return redirect()->route('proyectos.index')->with('error', 'Proyecto no encontrado');
        }
        return view("proyecto.proyecto-editar", compact('proyecto', 'estados', 'estudiantes', 'tutores', 'secciones'));
    }
    public function edit_gestion_proyecto(Request $request)
    {
        $proyectos = Proyecto::with([
            'seccion.departamento',
            'estudiantes',
            'coordinadorr',
            'tutorr.seccionesTutoreadas',
            'estadoo'
        ])
        ->whereHas('estadoo', function ($query) {
            $query->where('nombre_estado', '=', 'Disponible');
        })
        ->get();

        $estados = Estado::all();
        $estudiantes = Estudiante::all();
        $secciones = Seccion::all();
        $tutores = User::role('tutor')
            ->whereHas('seccionesTutoreadas')
            ->with('seccionesTutoreadas')
            ->get();

        if ($request->has('tutor_id') && $request->has('seccion_id')) {
            $tutor = User::role('tutor')->find($request->input('tutor_id'));
            if (!$tutor) {
                return redirect()->back()->with('error', 'El tutor seleccionado no existe.');
            }

            $seccionTutor = $tutor->seccionesTutoreadas()->where('id', $request->input('seccion_id'))->first();
            if (!$seccionTutor) {
                return redirect()->back()->with('error', 'El tutor no pertenece a la sección seleccionada.');
            }

            $proyecto = Proyecto::findOrFail($request->input('proyecto_id'));
            $proyecto->tutor_id = $tutor->id;
            $proyecto->seccion_id = $request->input('seccion_id');
            $proyecto->save();

            return redirect()->route('gestionProyectos.gestionProyectos')->with('success', 'Tutor asignado correctamente.');
        }

        if (!$proyectos) {
            return redirect()->route('gestionProyectos.gestionProyectos')->with('error', 'Proyecto no encontrado');
        }

        return view("gestionProyectos.gestionProyectos", compact('proyectos', 'estados', 'estudiantes', 'tutores', 'secciones'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'estado' => 'required|integer',
            'periodo' => 'required|string|max:255',
            'lugar' => 'required|string|max:255',
            'coordinador' => 'required|integer',
            'id_seccion' => 'required|integer',
        ]);

        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return redirect()->route('proyectos.index')->with('error', 'Proyecto no encontrado');
        }

        $proyecto->update($data);
        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado con éxito');
    }

    public function asignarEstudiante(Request $request, $idProyecto)
    {
        $request->validate([
            'idEstudiante' => 'required|string|exists:estudiantes,id_estudiante',
        ], [
            'idEstudiante.exists' => 'El estudiante seleccionado no existe en la base de datos.',
            'idEstudiante.required' => 'El estudiante no esta registrado.',
        ]);

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
    public function gestionActualizar(Request $request, $id)
{   
    
    // Decodificar los estudiantes seleccionados desde el input JSON
    $estudiantesSeleccionados = json_decode($request->input('estudiantes'), true);

    // Validar los datos recibidos
    $validatedData = $request->validate([
        'idTutor' => 'nullable|string|exists:users,id_usuario',
        'lugar' => 'nullable|string|max:255',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        'estado' => 'required|integer|exists:estados,id_estado',
        'seccion_id' => 'required|string|exists:secciones,id_seccion',
        'horas' => 'required|integer|min:0',
    ], [
        // Mensajes personalizados para validación
        'idTutor.exists' => 'El tutor seleccionado no es válido.',
        'estado.required' => 'El estado del proyecto es obligatorio.',
        'estado.exists' => 'El estado seleccionado no es válido.',
        'seccion_id.required' => 'La sección es obligatoria.',
        'seccion_id.exists' => 'La sección seleccionada no es válida.',
        'horas.required' => 'Debe especificar las horas requeridas.',
        'horas.min' => 'Las horas requeridas deben ser un número positivo.',
    ]);

    // Validar que existan estudiantes seleccionados
    if (!$estudiantesSeleccionados || !is_array($estudiantesSeleccionados) || count($estudiantesSeleccionados) === 0) {
        return redirect()->back()->withErrors(['estudiantes' => 'Debe seleccionar al menos un estudiante.'])->withInput();
    }

    // Verificar que el tutor exista si se proporciona
    $idTutor = $validatedData['idTutor'] ?? null; // Usar coalescencia nula para evitar el error

    if (!$idTutor) {
        // Redirigir si no se seleccionó un tutor
        return redirect()->back()->withErrors(['idTutor' => 'Debe seleccionar un tutor.'])->withInput();
    }

    $tutor = User::find($idTutor);

    if (!$tutor) {
        return redirect()->back()->withErrors(['idTutor' => 'El tutor ingresado no existe.'])->withInput();
    }

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

    // Actualizar los datos del proyecto
    $proyecto->update([
        'tutor' => $tutor->id_usuario ?? null,
        'lugar' => $validatedData['lugar'],
        'fecha_inicio' => $validatedData['fecha_inicio'],
        'fecha_fin' => $validatedData['fecha_fin'],
        'estado' => $validatedData['estado'],
        'seccion_id' => $validatedData['seccion_id'],
        'horas' => $validatedData['horas'],
    ]);

    // Redirigir con éxito
    return redirect()->route('gestion-proyecto')->with('success', 'Proyecto actualizado correctamente.');
}


    public function eliminarEstudiante($proyectoId, $estudianteId)
    {
        // Buscar el proyecto y estudiante en la tabla pivot
        $proyecto = Proyecto::findOrFail($proyectoId);

        // Verificar si el estudiante está asociado al proyecto
        $proyecto->estudiantes()->detach($estudianteId);

        return back()->with('success', 'Estudiante eliminado del proyecto exitosamente.');
    }
    public function actualizar(Request $request, $id)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'idTutor' => 'required|string|exists:users,id_usuario',
            'lugar' => 'nullable|string|max:255',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|integer|exists:estados,id_estado',
            'seccion_id' => 'required|string|exists:secciones,id_seccion',
        ]);

        $tutor = User::find($request->idTutor);

        if ($validatedData['idTutor'] && !$tutor) {
            return redirect()->back()->withErrors(['tutor' => 'El tutor ingresado no existe.']);
        }

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update([
            'nombre_proyecto' => $validatedData['nombre_proyecto'],
            'tutor' => $tutor->id_usuario ?? null,
            'lugar' => $validatedData['lugar'],
            'fecha_inicio' => $validatedData['fecha_inicio'],
            'fecha_fin' => $validatedData['fecha_fin'],
            'estado' => $validatedData['estado'],
            'seccion_id' => $validatedData['seccion_id'],
        ]);

        return redirect()->route('proyecto-g')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function generar(Request $request)
    {
        $action = $request->input('action');
        $proyectos = $request->input('proyectos', []);

        switch ($action) {
            case 'pdf':
                return $this->generarPDF($proyectos);
            case 'excel':
                return $this->generarExcel($proyectos);
            case 'delete':
                Proyecto::whereIn('id_proyecto', $proyectos)->delete();
                return redirect()->route('proyecto-g')->with('success', 'Proyectos eliminados correctamente.');
            default:
                return redirect()->route('proyecto-g')->with('error', 'Acción no válida.');
        }
    }

    private function generarPDF($proyectos)
    {
        $proyectosData = Proyecto::with(['estudiantes.usuario', 'tutorr', 'estadoo', 'seccion'])
            ->whereIn('id_proyecto', $proyectos)
            ->get();
        $pdf = Pdf::loadView('proyecto.pdf', compact('proyectosData'))->setPaper('a4', 'landscape');
        return $pdf->download('proyectos_' . date('Y-m-d') . '.pdf');
    }


    private function generarExcel($proyectos)
    {
        return Excel::download(new ProyectosExport($proyectos), 'proyectos_' . date('Y-m-d') . '.xlsx');
    }


    public function destroy($id)
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return redirect()->back()->with('error', 'Proyecto no encontrado');
        }

        $proyecto->delete();

        $currentRoute = request()->route()->getName();
        if ($currentRoute == 'proyecto-g') {
            return redirect()->route('proyecto-g')->with('success', 'Proyecto eliminado con éxito');
        } else {
            return redirect()->route('proyecto-disponible')->with('success', 'Proyecto eliminado con éxito');
        }
    }

    public function filtrarProyectos(Request $request)
    {
        $estado = $request->input('estado');
        $periodo = $request->input('periodo');
        $query = Proyecto::query();

        if ($estado) {
            $query->where('estado', $estado);
        }

        if ($periodo) {
            $query->where('periodo', $periodo);
        }

        $ListProyecto = $query->get();

        return view("Proyecto.indexProyecto", compact("ListProyecto"));
    }

    public function asignarResponsable(Request $request, $id)
    {
        $data = $request->validate([
            'coordinador' => 'required|integer|exists:usuarios,id',
        ]);

        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return redirect()->route('proyectos.index')->with('error', 'Proyecto no encontrado');
        }

        $proyecto->update(['coordinador' => $data['coordinador']]);
        return redirect()->route('proyectos.index')->with('success', 'Responsable asignado con éxito');
    }

    public function generarInforme()
    {
        $proyectos = Proyecto::all();
        $pdf = Pdf::loadView('test', compact('proyectos'));
        return $pdf->download('informe_progreso.pdf');
    }

    public function reporteProgreso()
    {
        $resultados = DB::table('Estudiantes as e')
            ->select(
                'e.id_estudiante',
                'e.nombre as nombre_estudiante',
                'p.nombre_proyecto',
                'e.porcentaje_completado as progreso_proyecto',
                'hs.horas_completadas as horas_sociales',
                'p.estado as estado_proyecto',
                'a.fecha_asignacion'
            )
            ->join('proyectos_estudiantes as pe', 'e.id_estudiante', '=', 'pe.id_estudiantes')
            ->join('Proyectos as p', 'pe.id_proyectos', '=', 'p.id_proyecto')
            ->leftJoin('Horas_Sociales as hs', 'e.id_estudiante', '=', 'hs.id_estudiante')
            ->leftJoin('Asignaciones as a', function ($join) {
                $join->on('e.id_estudiante', '=', 'a.id_estudiante')
                    ->on('a.id_proyecto', '=', 'p.id_proyecto');
            })
            ->orderBy('e.nombre')
            ->get();

        return view('Proyecto.reporteProgreso', compact('resultados'));
    }

    public function createform()
    {
        return view('Proyecto.createForm');
    }

    public function storedate(Request $request)
    {
        $validatedData = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Proyecto::asignarFechas($validatedData);
        return redirect()->route('proyectos.index')->with('success', 'Fechas asignadas exitosamente.');
    }

    // Método para mostrar los proyectos disponibles
    public function proyectos_disponibles()
    {
        $proyectos = Proyecto::where('estado', 1)->get(); // 1 = Disponible
        return view('proyecto.proyecto-disponible', compact('proyectos'));
    }

    public function retornar_departamentos()
    {
        /*
        $departamentos = Departamento::all();
        $secciones = Seccion::all();
        return view("proyecto.publicar-proyecto", compact('departamentos', 'secciones'));
        */
        $departamentos = Departamento::all();
        $secciones = Seccion::with('departamento')->get();
        return view("proyecto.publicar-proyecto", compact('departamentos', 'secciones'));
    }

    public function totalProyectosActivos()
    {
        return Proyecto::whereBetween('estado', [1, 6])->count();
    }

    /*public function totalProyectosAsignados()
    {
        $user = Auth::user();

        //hacemos el filtro para el rol coordinador
        if ($user->hasRole('Coordinador')) {
            $seccion = DB::table('secciones') //buscamos en la tabla secciones de la base de datos para tener acceso al id_coordinador y el id_seccion para tener el valor del departamento o seccion del coordinador
                ->where('id_coordinador', $user->id_usuario)
                ->pluck('id_seccion')
                ->first();

            //luego abrimos una query del modelo proyecto para tener acceso a seccion_id que es el id que almacena el valor del depa o seccion del coordinador
            $query = Proyecto::query();
            $query->where('seccion_id', $seccion); //comparamos con el depa del coordinador y procedemos a almacenar el count
            $totalProyectosAsignados = $query->count();
        } elseif ($user->hasRole('Tutor')) {
            $totalProyectosAsignados = Asignacion::where('id_tutor', $user->id_usuario)
                ->distinct('id_proyecto')
                ->count('id_proyecto');
        } else {
            $totalProyectosAsignados = \App\Models\Proyecto::count();;
        }

        return $totalProyectosAsignados;
    }*/

    public function totalProyectosAsignados()
    {
        $totalProyectosAsignados = Proyecto::count();
        return $totalProyectosAsignados;
    }


    public function obtenerDatosGrafico()
    {
        $user = Auth::user();

        if ($user->hasRole('Tutor')) {
            $datos = DB::table('asignaciones')
                ->join('proyectos', 'asignaciones.id_proyecto', '=', 'proyectos.id_proyecto')
                ->selectRaw("
                    COUNT(CASE WHEN proyectos.estado IN (2, 3, 4) THEN 1 END) as en_progreso,
                    COUNT(CASE WHEN proyectos.estado IN (5, 7) THEN 1 END) as completados,
                    COUNT(CASE WHEN proyectos.estado IN (1, 8, 9) THEN 1 END) as en_revision
                ")
                ->where('asignaciones.id_tutor', $user->id_usuario)
                ->first();
        } else {

            $datos = DB::table('proyectos')
                ->selectRaw("
                    COUNT(CASE WHEN estado IN (2, 3, 4) THEN 1 END) as en_progreso,
                    COUNT(CASE WHEN estado IN (5, 7) THEN 1 END) as completados,
                    COUNT(CASE WHEN estado IN (1, 8, 9) THEN 1 END) as en_revision
                ")
                ->first();
        }

        return response()->json([
            'labels' => ['En Progreso', 'Completados', 'En Revisión'],
            'data' => [$datos->en_progreso, $datos->completados, $datos->en_revision],
        ]);
    }

    public function obtenerEstudiantesYProyectosPorFecha()
    {
        $user = Auth::user();

        if ($user->hasRole('Tutor')) {
            $estudiantesPorFecha = DB::table('asignaciones')
                ->join('estudiantes', 'asignaciones.id_estudiante', '=', 'estudiantes.id_estudiante')
                ->selectRaw('DATE(asignaciones.fecha_asignacion) as fecha, COUNT(*) as total_estudiantes')
                ->where('asignaciones.id_tutor', $user->id_usuario)
                ->groupBy('fecha')
                ->orderBy('fecha', 'asc')
                ->get();

            $proyectosPorFecha = DB::table('asignaciones')
                ->join('proyectos', 'asignaciones.id_proyecto', '=', 'proyectos.id_proyecto')
                ->selectRaw('DATE(asignaciones.fecha_asignacion) as fecha, COUNT(*) as total_proyectos')
                ->where('asignaciones.id_tutor', $user->id_usuario)
                ->groupBy('fecha')
                ->orderBy('fecha', 'asc')
                ->get();
        } else {
            $estudiantesPorFecha = DB::table('estudiantes')
                ->selectRaw('DATE(created_at) as fecha, COUNT(*) as total_estudiantes')
                ->groupBy('fecha')
                ->orderBy('fecha', 'asc')
                ->get();

            $proyectosPorFecha = DB::table('proyectos')
                ->selectRaw('DATE(created_at) as fecha, COUNT(*) as total_proyectos')
                ->groupBy('fecha')
                ->orderBy('fecha', 'asc')
                ->get();
        }

        $fechas = $estudiantesPorFecha->pluck('fecha')->merge($proyectosPorFecha->pluck('fecha'))->unique()->sort();

        $data = $fechas->map(function ($fecha) use ($estudiantesPorFecha, $proyectosPorFecha) {
            $totalEstudiantes = $estudiantesPorFecha->firstWhere('fecha', $fecha)->total_estudiantes ?? 0;
            $totalProyectos = $proyectosPorFecha->firstWhere('fecha', $fecha)->total_proyectos ?? 0;

            return [
                'fecha' => $fecha,
                'total_estudiantes' => $totalEstudiantes,
                'total_proyectos' => $totalProyectos,
            ];
        });

        return response()->json($data);
    }

    //retorna vista gertor de TI
    public function detallesSolicitud($id_proyecto)
    {

        $proyectos = Proyecto::with('estudiantes.usuario')->get();
        // Buscar el proyecto por su nombre
        $proyecto = Proyecto::where('id_proyecto', $id_proyecto)->with('estudiantes.usuario')->firstOrFail();

        // Pasar el proyecto a la vista
        return view('proyecto.VerdetallesSolicitud', compact('proyecto'));
    }
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




    //retorna vista solicitud de proyecto
    public function solicitud_proyecto()
    {
        return view('proyecto.solicitud-proyecto');
    }

    public function proyecto__disponible_list()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene el rol de 'Estudiante'
        if ($user->hasRole('Estudiante')) {
            // Obtener la sección del estudiante
            $userSeccion = DB::table('estudiantes')
                ->where('id_usuario', $user->id_usuario)
                ->pluck('id_seccion') // Obtener el ID de la sección asignada
                ->first();
            if ($userSeccion) {
                // Filtrar proyectos por la sección y estado
                $proyectos = Proyecto::where('seccion_id', $userSeccion)
                    ->where('estado', 1) // Solo proyectos disponibles
                    ->get();

                // Retornar la vista con los proyectos filtrados
                return view('proyecto.proyecto-disponible-list', compact('proyectos'));
            } else {
                // Si no hay sección asignada, redirigir con error
                return redirect()->route('proyectos.disponibles')->with('error', 'No tienes una sección asignada.');
            }
        }

        // Si el usuario no tiene el rol 'Estudiante', redirigir con error
        return redirect()->route('login')->with('error', 'Acceso denegado.');
    }

    public function proyectosDisponibles()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene el rol de 'Estudiante'
        if ($user->hasRole('Estudiante')) {
            // Obtener la sección asignada al estudiante
            $userSeccion = DB::table('estudiantes')
                ->where('id_usuario', $user->id_usuario)
                ->pluck('id_seccion') // Obtener solo el ID de la sección
                ->first();

            // Validar que el estudiante tenga una sección asignada
            if ($userSeccion) {
                // Filtrar los proyectos por sección
                $proyectos = Proyecto::where('seccion_id', $userSeccion)
                    ->where('estado', 1) // Solo proyectos disponibles
                    ->with(['tutorr', 'estadoo'])
                    ->get(['id_proyecto', 'nombre_proyecto', 'tutor', 'lugar', 'fecha_inicio', 'fecha_fin', 'estado']);

                return response()->json($proyectos);
            }

            // Si no tiene sección, devolver una colección vacía como respuesta
            return response()->json([]);
        }

        // Si el usuario no tiene el rol 'Estudiante', devolver error de acceso denegado
        return response()->json(['error' => 'Acceso denegado'], 403);
    }
    public function proyectosDisponiblesPorSeccion($id)
    {
        $proyectos = Proyecto::where('estado', 1)
            ->where('seccion_id', $id)
            ->with(['tutorr', 'estadoo'])
            ->get(['id_proyecto', 'nombre_proyecto', 'tutor', 'lugar', 'fecha_inicio', 'fecha_fin', 'estado']);

        return response()->json($proyectos);
    }

    public function obtenerProyectosDashboard()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene el rol de 'Estudiante'
        if ($user->hasRole('Estudiante')) {
            // Obtener la sección asignada al estudiante
            $userSeccion = DB::table('estudiantes')
                ->where('id_usuario', $user->id_usuario)
                ->pluck('id_seccion') // Obtener solo el ID de la sección
                ->first();

            // Verificar que se encontró la sección
            if ($userSeccion) {
                // Filtrar los proyectos por la sección y estado
                $proyectos = Proyecto::where('seccion_id', $userSeccion)
                    ->where('estado', 1) // Solo proyectos disponibles
                    ->get(['id_proyecto', 'nombre_proyecto', 'descripcion_proyecto', 'horas_requeridas', 'estado']);

                // Retornar la vista con los proyectos filtrados
                $notificaciones = app(NotificacionController::class)->getNotifiaciones(Auth::user()->id_usuario);
                return view('estudiantes.dashboard', compact('proyectos', 'notificaciones'));
            }

            // Si no hay sección asignada, redirigir con error
            return redirect()->route('login')->with('error', 'No tienes una sección asignada.');
        }

        // Si el usuario no tiene el rol 'Estudiante', redirigir con error
        return redirect()->route('login')->with('error', 'Acceso denegado.');
    }

    public function mostrarProyecto($id)
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene el rol de 'Estudiante'
        if ($user->hasRole('Estudiante')) {
            // Obtener la sección asignada al estudiante
            $userSeccion = DB::table('estudiantes')
                ->where('id_usuario', $user->id_usuario)
                ->pluck('id_seccion') // Obtener solo el ID de la sección
                ->first();

            // Validar que el estudiante tenga una sección asignada
            if ($userSeccion) {
                // Filtrar el proyecto por sección
                $proyecto = Proyecto::with(['seccion', 'estadoo'])
                    ->where('id_proyecto', $id)
                    ->where('seccion_id', $userSeccion)
                    ->first();

                if ($proyecto) {
                    $estudiantes = Estudiante::where('id_seccion', $userSeccion)->get();

                    // Si el proyecto pertenece a la sección, mostrarlo
                    return view('estudiantes.proyecto-disponibles', compact('proyecto', 'estudiantes'));
                }

                // Si el proyecto no pertenece a la sección, redirigir con error
                return redirect()->route('proyectos.disponibles')->with('error', 'No tienes permiso para ver este proyecto.');
            }

            // Si el estudiante no tiene sección, redirigir con error
            return redirect()->route('proyectos.disponibles')->with('error', 'No tienes una sección asignada.');
        }

        // Si el usuario no tiene el rol 'Estudiante', redirigir con error
        return redirect()->route('login')->with('error', 'Acceso denegado.');
    }
    public function mostrarDetalle($id)
    {
        try {

            // Primero debug del ID recibido
            \Log::info('ID recibido: ' . $id);

            // Buscar el proyecto
            $proyecto = Proyecto::with(['seccion.departamento'])->findOrFail($id);

            // Debug del proyecto encontrado
            \Log::info('Proyecto encontrado:', $proyecto->toArray());

            // Intentar ambas formas de pasar la variable
            return view('proyecto.detalle-proyecto')
                ->with('proyecto', $proyecto)
                ->with('debug', true);
        } catch (\Exception $e) {
            \Log::error('Error en mostrarDetalle: ' . $e->getMessage());
            return back()->with('error', 'Proyecto no encontrado');
        }
    }

    //editar
    public function edit_proyecto($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $departamentos = Departamento::all();
        $secciones = Seccion::all();

        return view('proyecto.editar-proyecto', compact('proyecto', 'departamentos', 'secciones'));
    }

    public function update_proyecto(Request $request, $id)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'ubicacion' => 'required|string|max:255',
            'horas' => 'required|integer|min:1',
            'id_seccion' => 'required|exists:secciones,id_seccion',
        ]);

        $proyecto = Proyecto::findOrFail($id);


        $proyecto->update([
            'nombre_proyecto' => $data['titulo'],
            'descripcion_proyecto' => $data['descripcion'],
            'lugar' => $data['ubicacion'],
            'horas_requeridas' => $data['horas'],
            'id_seccion' => $data['id_seccion'],
        ]);

        return redirect()->route('proyecto-disponible')->with('success', 'Proyecto actualizado con éxito');
    }


    public function obtenerDetalleProyecto($id)
    {
        try {
            $proyecto = Proyecto::with(['seccion.departamento'])->findOrFail($id);
            return view('proyecto.detalle-proyecto', compact('proyecto'));
        } catch (\Exception $e) {
            \Log::error('Error en obtenerDetalleProyecto: ' . $e->getMessage());
            return back()->with('error', 'Proyecto no encontrado');
        }
    }

    public function descargarPDF($id)
    {
        $proyecto = Proyecto::with('seccion')->findOrFail($id);

        $nombreArchivo = str_replace(' ', '_', $proyecto->nombre_proyecto) . '.pdf';

        $pdf = Pdf::loadView('proyecto.pdf_proyecto', compact('proyecto'));
        return $pdf->download($nombreArchivo);
    }
    public function GetTutoresPorSeccion($id)
    {
        $tutoresSeccion = DB::table('seccion_tutor')
            ->join('users', 'seccion_tutor.id_tutor', '=', 'users.id_usuario')
            ->select('users.id_usuario', 'users.name')
            ->where('seccion_tutor.id_seccion', $id)
            ->get();
        return response()->json($tutoresSeccion);
    }

    public function obtenerDetallesProyectoFU($id)
    {
        try {
            $proyecto = Proyecto::with(['estudiantes.usuario'])->findOrFail($id);
            $primeraSeccion = $proyecto->seccion()->first();
            return response()->json([
                'ubicacion' => $proyecto->lugar,
                'fecha_inicio' => $proyecto->fecha_inicio,
                'fecha_fin' => $proyecto->fecha_fin,
                'horas_requeridas' => $proyecto->horas_requeridas,
                'seccion' => $primeraSeccion ? [
                    'id' => $primeraSeccion->id_seccion,
                    'nombre' => $primeraSeccion->nombre_seccion,
                ] : null,
                'estudiantes' => $proyecto->estudiantes->map(function ($estudiante) {
                    return [
                        'id_estudiante' => $estudiante->id_estudiante,
                        'name' => $estudiante->usuario->name ?? 'Sin nombre',
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Proyecto no encontrado'], 404);
        }
    }
    public function solicitudes_proyectos(string $id)
    {
        $id = (int)$id;

        $solicitudes = Solicitud::where('id_proyecto', $id)->get();
        $proyecto = Proyecto::find($id);
        foreach ($solicitudes as $solicitud) {
            $estudiante = Estudiante::where('id_estudiante', $solicitud->id_estudiante)->first();
            $solicitud->nombre = User::find($estudiante->id_usuario)->name;
            //nombre del usuario asociado al id de estudiante
        }

        $estados = Estado::all();

        return view('proyecto.proyecto-solicitudes', compact('solicitudes', 'proyecto', 'estados'));
    }

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
    public function aprobarSolicitud(string $id, string $solicitudId)
    {
        $solicitud = Solicitud::find($solicitudId);
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
    
        // Guardar los cambios en Estudiante y Solicitud
        $estudiante->save();
        $solicitud->save();
    
        // Guardar la información de horas aceptadas en la tabla de historial
        HistoriaHorasActualizada::create([
            'id_estudiante' => $estudiante->id_estudiante,
            'id_solicitud' => $solicitud->solicitud_id,
            'id_proyecto' => $proyecto->id_proyecto,  // Registrar el id del proyecto
            'horas_aceptadas' => $solicitud->valor, // Horas aceptadas
            'fecha_aceptacion' => now(), // Fecha de aceptación
        ]);
    
        // Redirigir con mensaje de éxito
        return redirect()->route('solicitudesProyectos', [
            'id' => $proyecto->id_proyecto
        ])->with('success', 'Solicitud aprobada y horas registradas correctamente');
    }
    


    public function denegarSolicitud(string $id, string $solicitudId)
    {
        $solicitud = Solicitud::find($solicitudId);
        $proyecto = Proyecto::find($solicitud->id_proyecto);
        $estudiante = Estudiante::where('id_estudiante', $solicitud->id_estudiante)->first();
        $usuario = User::find($estudiante->id_usuario);

        if (!$solicitud) {
            return redirect()->route('proyecto-g')->with('error', 'Solicitud no encontrada');
        }

        $solicitud->estado = 7;

        $solicitud->save();

        return redirect()->route('solicitudesProyectos', [
            'id' => $proyecto->id_proyecto
        ])->with('success', 'Solicitud rechazada correctamente');
    }
}
