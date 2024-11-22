<?php
namespace App\Http\Controllers;



use App\Models\ProyectosEstudiantes;
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
use Illuminate\Container\Attributes\DB as AttributesDB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProyectoController extends Controller
{
    public function index()
    {
        $ListProyecto = Proyecto::with([
            'seccion.departamento',
            'estudiantes',
            'coordinadorr',
            'tutorr.seccionesTutoreadas',
            'estadoo'
        ])
            ->whereHas('estadoo', function ($query) {
                $query->where('nombre_estado', '!=', 'Disponible');
            })
            ->get();

        return view("proyecto.proyecto-general", compact("ListProyecto"));
    }

    public function store_solicitud(Request $request)
    {
      
        try {
            $proyecto = new Proyecto();
            $proyecto->nombre_proyecto = $request->nombre_proyecto;
            $proyecto->descripcion_proyecto = strip_tags($request->descripcion);
            $proyecto->lugar = $request->lugar;
            $proyecto->estado = 9; //estado solicitud
            $proyecto->horas_requeridas = 0;//a revisar 
            $proyecto->periodo = now()->format('Y-m');
            $proyecto->coordinador = auth()->id();  
            $proyecto->seccion_id = $request->id_seccion; 
            $proyecto->fecha_inicio = $request->fecha_inicio;
            $proyecto->fecha_fin = $request->fecha_fin;
    
            $proyecto->save();
    
            return redirect()->back()->with('success', 'Proyecto creado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al crear proyecto: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    public function solicitudes_coordinador()
    {
        //$proyectos = Proyecto::where('estado', 'Solicitud')->get();
        $proyectos = Proyecto::All();

        // Retorna la vista con los proyectos
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
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'horas' => 'required|integer|min:1',
            'ubicacion' => 'required|string|max:255',
            'id_seccion' => 'required|exists:secciones,id_seccion',
        ]);

        try {
            $proyecto = new Proyecto();
            $proyecto->nombre_proyecto = $validatedData['titulo'];
            $proyecto->descripcion_proyecto = strip_tags($validatedData['descripcion']);
            $proyecto->horas_requeridas = $validatedData['horas'];
            $proyecto->lugar = $validatedData['ubicacion'];
            $proyecto->estado = 1;
            $proyecto->periodo = now()->format('Y-m');
            $proyecto->coordinador = auth()->id();
            $proyecto->seccion_id = $validatedData['id_seccion']; // Asegúrate de que este campo se guarde
            $proyecto->fecha_inicio = now();
            $proyecto->fecha_fin = now()->addMonths(3);

            $proyecto->save();

            return redirect()
                ->back()
                ->with('success', 'Proyecto creado exitosamente');

        } catch (\Exception $e) {
            \Log::error('Error al crear proyecto: ' . $e->getMessage());
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
    public function edit_gestion_proyecto()
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
        $validatedData = $request->validate([
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
            'tutor' => $tutor->id_usuario ?? null,
            'lugar' => $validatedData['lugar'],
            'fecha_inicio' => $validatedData['fecha_inicio'],
            'fecha_fin' => $validatedData['fecha_fin'],
            'estado' => $validatedData['estado'],
            'seccion_id' => $validatedData['seccion_id'],
        ]);

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

    public function totalProyectosAsignados()
    {
        $user = Auth::user(); 

        if ($user->hasRole('Tutor')) {
            $totalProyectosAsignados = Asignacion::where('id_tutor', $user->id_usuario)
                ->distinct('id_proyecto') 
                ->count('id_proyecto'); 
        } else {
            $totalProyectosAsignados = \App\Models\Proyecto::count();
        }

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
    public function gestor_de_TI()
    {
        return view('proyecto.gestor-de-TI');
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
                return view('estudiantes.dashboard', compact('proyectos'));
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
                    // Si el proyecto pertenece a la sección, mostrarlo
                    return view('estudiantes.proyecto-disponibles', compact('proyecto'));
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
}