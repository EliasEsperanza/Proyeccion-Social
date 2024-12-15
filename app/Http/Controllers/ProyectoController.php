<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyecto\StoreRequest;
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
use App\Http\Controllers\NotificacionController;
use App\Http\Requests\Proyecto\AsignarProyectoRequest;
use App\Http\Requests\Proyecto\UpdateRequest;

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

        return view("proyecto.proyecto-en-curso", compact("ListProyecto"));
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_proyecto', 'id_proyecto');
    }
    

    //agregar id de estudiantes a un proyecto en fase de solicitud
    //to service
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

    public function store(StoreRequest $request)
    {

        try {
            // Crear proyecto 
            $proyecto = new Proyecto();
            $proyecto->nombre_proyecto = htmlspecialchars($request['titulo'], ENT_QUOTES, 'UTF-8'); // XSS es importante aquí para evitar inyección de scripts
            $proyecto->descripcion_proyecto = strip_tags($request['descripcion'], '<p><a><ul><li><ol><strong><em>');
            $proyecto->horas_requeridas = $request['horas'];
            $proyecto->lugar = htmlspecialchars($request['ubicacion'], ENT_QUOTES, 'UTF-8');
            $proyecto->estado = 1;
            $proyecto->periodo = now()->format('Y-m');
            $proyecto->coordinador = auth()->id();  // Coordinador actual
            $proyecto->seccion_id = $request['id_seccion'];
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
                'datos' => $request,
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
    //to service

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
        $tutores = User::role('Tutor')
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
    //###########################################################################################
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


        $proyectoExistente = Proyecto::where('nombre_proyecto', $data['nombre_proyecto'])
            ->where('id', '!=', $id) // oviando el id actual
            ->first();

        //validar que no exista el mismo nombre de proyecto
        if ($proyectoExistente) {
            return back()->withErrors(['titulo' => 'Ya existe un proyecto con este nombre.'])->withInput();
        }

        $proyecto->update($data);
        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado con éxito');
    }

//###########################################################################################
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
                //ruta a cambiar
                return redirect()->route('proyecto-g')->with('success', 'Proyectos eliminados correctamente.');
            default:
                return redirect()->route('proyecto-g')->with('error', 'Acción no válida.');
        }
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return redirect()->back()->with('error', 'Proyecto no encontrado');
        }

        $proyecto->delete();

        $currentRoute = request()->route()->getName();
                //ruta a cambiar

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
//###########################################################################################
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

    //###########################################################################################
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

    //retorna vista detallesSolicitud
    public function detallesSolicitud($id_proyecto)
    {

        $proyectos = Proyecto::with('estudiantes.usuario')->get();
        // Buscar el proyecto por su nombre
        $proyecto = Proyecto::where('id_proyecto', $id_proyecto)->with('estudiantes.usuario')->firstOrFail();

        // Pasar el proyecto a la vista
        return view('proyecto.VerdetallesSolicitud', compact('proyecto'));
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
    //////////////////////////

    public function update_proyecto(UpdateRequest $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);

        $proyecto->update($request->validated()->all());

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
}
