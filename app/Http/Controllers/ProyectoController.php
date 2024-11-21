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

class ProyectoController extends Controller
{
    public function index()
    {
        $ListProyecto = Proyecto::with('seccion.departamento','estudiantes','coordinadorr','tutorr.seccionesTutoreadas','estadoo')->get();
        // dd($ListProyecto);
        return view("proyecto.proyecto-general", compact("ListProyecto"));
    }

    public function retornar_proyectos()
    {
        $proyectos = Proyecto::with('seccion.departamento','estudiantes','coordinadorr','tutorr.seccionesTutoreadas','estadoo')->get();
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
        $estados= Estado::all();
        $estudiantes= Estudiante::all(); 
        $tutores = User::role('tutor')->get();
        if (!$proyecto) {
            return redirect()->route('proyectos.index')->with('error', 'Proyecto no encontrado');
        }
        // dd($proyecto);
        return view("proyecto.proyecto-editar", compact('proyecto', 'estados', 'estudiantes','tutores'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'estado' => 'required|integer',
            'periodo' => 'required|string|max:255',
            'lugar' => 'required|string|max:255',
            'coordinador' => 'required|integer',
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
            'idEstudiante.required' => 'El ID del estudiante es requerido.',
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
        ]);
    
        // Buscar el tutor por nombre
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
        ]);
    
        return redirect()->route('proyecto-g')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return redirect()->route('proyectos.index')->with('error', 'Proyecto no encontrado');
        }

        $proyecto->delete();
        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado con éxito');
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

    public function obtenerDatosGrafico()
    {
        $datos = DB::table('proyectos')
            ->selectRaw("
                COUNT(CASE WHEN estado IN (2, 3, 4) THEN 1 END) as en_progreso,
                COUNT(CASE WHEN estado IN (5, 7) THEN 1 END) as completados,
                COUNT(CASE WHEN estado IN (1, 8, 9) THEN 1 END) as en_revision
            ")
            ->first();

        return response()->json([
            'labels' => ['En Progreso', 'Completados', 'En Revisión'],
            'data' => [$datos->en_progreso, $datos->completados, $datos->en_revision],
        ]);
    } 

    public function obtenerEstudiantesYProyectosPorFecha()
    {
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

}

