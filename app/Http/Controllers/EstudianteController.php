<?php
namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

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

        return view("estudiante.index", compact("ListEstudiantes")); 
    }

    // Mostrar formulario para crear un nuevo estudiante
    public function create()
    {
        return view("estudiante.create");
    }

    // Almacenar un nuevo estudiante en la base de datos
    public function store(Request $request)
    {
        $data = $this->validarEstudiante($request);

        Estudiante::create($data);

        return redirect()->route('estudiante.index')->with('success', 'Estudiante creado con éxito');
    }

    // Mostrar un estudiante específico por su ID
    public function show(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiante.index')->with('error', 'Estudiante no encontrado');
        }

        return view("estudiante.show", compact('estudiante')); 
    }

    // Mostrar formulario para editar un estudiante
    public function edit(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiante.index')->with('error', 'Estudiante no encontrado');
        }

        return view("estudiante.edit", compact('estudiante'));
    }

    // Actualizar los datos de un estudiante existente
    public function update(Request $request, string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiante.index')->with('error', 'Estudiante no encontrado');
        }

        $data = $this->validarEstudiante($request);

        $estudiante->update($data);

        return redirect()->route('estudiante.index')->with('success', 'Estudiante actualizado con éxito');
    }

    // Eliminar un estudiante
    public function destroy(string $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return redirect()->route('estudiante.index')->with('error', 'Estudiante no encontrado');
        }

        $estudiante->delete();

        return redirect()->route('estudiante.index')->with('success', 'Estudiante eliminado con éxito');
    }
}
