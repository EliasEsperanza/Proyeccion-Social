<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Exports\EstudianteExport;
use App\Http\Requests\Estudiante\Solicitud_avance_horasRequest;
use App\Models\Asignacion;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Proyecto;
use App\Models\ProyectosEstudiantes;
use App\Models\Seccion;
use App\Models\Solicitud;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    // Método que maneja la búsqueda de estudiantes
    private function buscarEstudiantes($query)
    {
        if ($query) {
            return Estudiante::where('nombre', 'LIKE', "%{$query}%")
                ->orWhereHas('seccion', function ($q) use ($query) {
                    $q->where('nombre', 'LIKE', "%{$query}%");
                })
                ->get();
        } else {
            return Estudiante::all();
        }
    }
    private function validarRegistro(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_seccion' => 'required|integer|exists:secciones,id',
        ]);
    }

    // Método que valida los datos de los estudiantes
    private function validarEstudiante(Request $request)
    {
        return $request->validate([
            'id_usuario' => 'required|integer|exists:users,id',
            'id_seccion' => 'required|integer|exists:secciones,id',
            'porcentaje_completado' => 'required|numeric|min:0|max:100',
            'horas_sociales_completadas' => 'required|integer|min:0',
            'nombre' => 'required|string|max:255',
        ]);
    }

    // Método para mostrar la lista de estudiantes (con o sin búsqueda)
    public function index(Request $request)
    {
        $query = $request->input('query');
        $ListEstudiantes = $this->buscarEstudiantes($query);
        $User = User::all();
        // dd($ListEstudiantes);
        return view("estudiante.index", compact("ListEstudiantes"));
    }

    // Mostrar formulario para crear un nuevo estudiante
    public function create()
    {
        $secciones = Seccion::all();
        // dd($secciones);
        return view("estudiante.create", compact("secciones"));
    }

    // Almacenar un nuevo estudiante en la base de datos
    public function store(Request $request)
    {
        $data = $this->validarEstudiante($request);

        Estudiante::create($data);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado con éxito');
    }

    // Mostrar un estudiante específico por su ID
    public function show(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiantes.index')->with('error', 'Estudiante no encontrado');
        }

        return view("estudiante.show", compact('estudiante'));
    }

    // Mostrar formulario para editar un estudiante
    public function edit(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiantes.index')->with('error', 'Estudiante no encontrado');
        }

        return view("estudiante.edit", compact('estudiante'));
    }

    // Actualizar los datos de un estudiante existente
    public function update(Request $request, string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiantes.index')->with('error', 'Estudiante no encontrado');
        }

        $data = $this->validarEstudiante($request);

        $estudiante->update($data);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado con éxito');
    }

    // Eliminar un estudiante
    public function destroy(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiantes.index')->with('error', 'Estudiante no encontrado');
        }

        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado con éxito');
    }

    public function exportExcel()
    {
        return Excel::download(new EstudianteExport, 'estudiantes.xlsx');
    }
    public function register(Request $request)
    {
        $data = $this->validarRegistro($request);

        $usuario = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);
        $usuario->assignRole('Estudiante');

        // Crear el estudiante
        Estudiante::create([
            'id_usuario' => $usuario->id,
            'id_seccion' => $data['id_seccion'],
            'nombre' => $data['name'],
            'porcentaje_completado' => 0,
            'horas_sociales_completadas' => 0,
        ]);

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante registrado exitosamente');
    }

    public function exportPDF()
    {
        $estudiantes = Estudiante::all();

        $pdf = Pdf::loadView('exports.estudiantesPDF', ['estudiantes' => $estudiantes]);
        return $pdf->download('estudiantes.pdf');
    }

    public function totalEstudiantes()
    {
        $user = Auth::user();

        if ($user->hasRole('Coordinador')) {

            // Inicializar la consulta de estudiantes
            $query = Estudiante::query();
            
            // Obtener la sección del coordinador
            $seccion = DB::table('secciones')
                ->where('id_coordinador', $user->id_usuario)
                ->pluck('id_seccion')
                ->first();

            // Filtrar estudiantes por la sección del coordinador
            $query->where('id_seccion', $seccion);
            $totalEstudiantes = $query->count();
        } else if ($user->hasRole('Tutor')) {
            // Obtener estudiantes asignados al tutor
            $totalEstudiantes = Asignacion::where('id_tutor', $user->id_usuario)
                ->distinct('id_estudiante') // Asegúrate de no contar estudiantes duplicados
                ->count('id_estudiante');
        } else {
            // Total general de estudiantes
            $totalEstudiantes = Estudiante::count();
        }

        return $totalEstudiantes;
    }


    public function seccionesDisponibles()
    {
        $secciones = DB::table('secciones')
            ->join('departamentos', 'secciones.id_departamento', '=', 'departamentos.id_departamento')
            ->select('secciones.id_seccion', 'secciones.nombre_seccion', 'departamentos.nombre_departamento')
            ->get();

        return response()->json($secciones);
    }

    public function estudiantesPorSeccion($idSeccion)
    {
        $estudiantes = Estudiante::with('usuario')
            ->whereDoesntHave('proyecto')
            ->where('id_seccion', $idSeccion)
            ->get();

        return response()->json($estudiantes);
    }

    public function obtenerNombreEstudiante($id)
    {
        $estudiante = Estudiante::with('usuario')
            ->where('id_estudiante', $id)
            ->first();

        if (!$estudiante || !$estudiante->usuario) {
            return null;
        }

        return $estudiante->usuario->name;
    }

    public function estudiantesPorSeccion_FIltroSinProyecto($idSeccion)
    {
        $estudiantes = Estudiante::with('usuario')
            ->where('id_seccion', $idSeccion)
            ->whereNotIn('id_estudiante', function ($query) {
                $query->select('id_estudiante')
                    ->from('proyectos_estudiantes');
            })
            ->get();

        return response()->json($estudiantes);
    }
    public function actualizarHorasView()
    {
        $user = auth()->user();

        //dd($user);

        $Estudiante = Estudiante::where('id_usuario', $user->id_usuario)->first();

        //dd($Estudiante);

        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', $Estudiante->id_estudiante)->first();
        if (!$proyectoEstudiante) {
            return view('estudiantes.actualizar-horas')->with([
                'proyecto' => null,
                'horas' => null,
            ]);
        }

        $proyecto = Proyecto::find($proyectoEstudiante->id_proyecto);
        $horas = $Estudiante;
        $horas->nombre = $user->name;
        $tutor = User::find($proyecto->tutor);
        return view('estudiantes.actualizar-horas')->with([
            'proyecto' => $proyecto,
            'horas' => $horas,
            'tutor' => $tutor,
        ]);
    }

    public function Solicitud_avance_horas(Solicitud_avance_horasRequest $request)
    {
        $nombreProyecto = Proyecto::find($request->idProyecto)->nombre_proyecto;

        try {
            //Cambiar el nombre del archivo por el id del usuario mas el id del proyecto y la fecha actual
            $nombreArchivo = 'comprobante' . '-' . auth()->user()->name . '-' . $nombreProyecto . '-' . now()->format('Y-m-d') . '.pdf';
            $rutaDocumento = $request->file('documentos')->storeAs('solicitudes', $nombreArchivo);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al subir el archivo');
        }

        $valorHoras = $request->horasTrabajadas;
        $estudiante = $request->idEstudiante_;
        $proyecto = $request->idProyecto;

        Solicitud::create([
            'id_estudiante' => $estudiante,
            'id_proyecto' => $proyecto,
            'valor' => $valorHoras,
            'documento' => $nombreArchivo,
            'estado' => 8,
        ]);


        return redirect()->back()->with('success', 'Solicitud enviada con éxito');
    }
}
