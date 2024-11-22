<?php

namespace App\Http\Controllers;

use App\Exports\EstudianteExport;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Proyecto;
use App\Models\ProyectosEstudiantes;
use App\Models\Seccion;
use App\Models\Solicitud;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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
        return Estudiante::count();
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
            ->where('id_seccion', $idSeccion)
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

        return view('estudiantes.actualizar-horas')->with([
            'proyecto' => $proyecto,
            'horas' => $horas,
        ]);
    }

    public function actualizarHoras(Request $request)
    {

        $request->validate(
            [
                'horasTrabajadas' => 'required|numeric|min:0',
                'documentos' => 'required|file|mimes:pdf',
            ],
            [
                'horasTrabajadas.required' => 'El campo horas trabajadas es obligatorio',
                'horasTrabajadas.numeric' => 'El campo horas trabajadas debe ser un número',
                'horasTrabajadas.min' => 'El campo horas trabajadas debe ser mayor a 0',
                'documentos.required' => 'El campo documento es obligatorio',
                'documentos.file' => 'El campo documento debe ser un archivo',
                'documentos.mimes' => 'El campo documento debe ser un archivo PDF',
            ]
        );

        $nombreProyecto = Proyecto::find($request->idProyecto)->nombre_proyecto;

        try {
            //Cambiar el nombre del archivo por el id del usuario mas el id del proyecto y la fecha actual
            $nombreArchivo = 'comprobante' . '-' . auth()->user()->name . '-' . $nombreProyecto . '-' . now()->format('Y-m-d') . '.pdf';
            $rutaDocumento = $request->file('documentos')->storeAs('documentos', $nombreArchivo, 'public');
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
            'estado' => 7,
        ]);

        return redirect()->back()->with('success', 'Solicitud enviada con éxito');
    }
}
