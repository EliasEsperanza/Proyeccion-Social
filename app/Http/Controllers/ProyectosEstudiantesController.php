<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\ProyectosEstudiantes;
use Illuminate\Http\Request;

use App\Models\Proyecto;

class ProyectosEstudiantesController extends Controller
{
    public function index()
    {
        $proyectos_estudiantes = ProyectosEstudiantes::all();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }

    public function getEstudiantesbyProyecto($id_proyectos)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::where('id_proyectos', $id_proyectos)->get();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }

    public function getProyectobyEstudiantes($id_estudiantes)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::where('id_estudiantes', $id_estudiantes)->get();
        return view('proyectos_estudiantes.index', compact('proyectos_estudiantes'));
    }


    public function create()
    {
        return view("proyectos_estudiantes.create");
    }


    public function store(Request $request)
    {
        $validacion = $request->validate([
            'id_proyectos' => 'required|integer',
            'id_estudiantes' => 'required|integer',
        ]);

        ProyectosEstudiantes::create($validacion);

        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Asignacion de estudiante a proyecto exitosa');
    }


    public function show(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);
        return view('proyectos_estudiantes.show', compact('proyectos_estudiantes'));
    }

    public function edit(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }
        return view("proyectos_estudiantes.edit", compact('proyectos_estudiantes'));
    }


    public function update(Request $request, string $id)
    {
        $validacion = $request->validate([
            'id_proyectos' => 'required|integer',
            'id_estudiantes' => 'required|integer',
        ]);

        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }

        $proyectos_estudiantes->update($validacion);
        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Modificacion de asignacion de estudiante a proyecto exitosa');
    }


    public function destroy(string $id)
    {
        $proyectos_estudiantes = ProyectosEstudiantes::find($id);

        if (!$proyectos_estudiantes) {
            return redirect()->route('proyectos_estudiantes.index')->with('error', 'No se econtró ese Proyecto');
        }

        $proyectos_estudiantes->delete();
        return redirect()->route('proyectos_estudiantes.index')->with('success', 'Elminacion de asignacion de estudiante a proyecto exitosa');;
    }
    public function Rechazar_solicitus_destroy(string $id_proyectoEstudiante)
    {
            // Buscar registros relacionados al proyecto
            $proyectos_estudiantes = ProyectosEstudiantes::where('id_proyecto', $id_proyectoEstudiante)->get();

            // Verificar si existen registros relacionados
            if ($proyectos_estudiantes->isEmpty()) {
                return redirect()->back()->with('error', 'No se encontraron registros relacionados a eliminar.');
            }

            // Eliminar registros relacionados
            ProyectosEstudiantes::where('id_proyecto', $id_proyectoEstudiante)->delete();

            // Buscar y eliminar el proyecto principal
            $proyecto = Proyecto::find($id_proyectoEstudiante);
            if (!$proyecto) {
                return redirect()->back()->with('error', 'El proyecto principal no se encontró.');
            }
            $proyecto->delete();
            return redirect()->back()->with('success', 'Registros eliminados correctamente.');
    }



    public function Detalles_proyecto()
    {
        $userId = auth()->user()->id_usuario;
        $estudiante = Estudiante::where('id_usuario', $userId)->first();

        if (!$estudiante) {
            return 'Estudiante no encontrado';
        }

        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', $estudiante->id_estudiante)
            ->with('proyecto')
            ->first();

        if (!$proyectoEstudiante || !$proyectoEstudiante->proyecto) {
            return 'No posee proyecto asignado';
        }

        $porcentaje = ($proyectoEstudiante->proyecto->horas_requeridas > 0) ? ($proyectoEstudiante->horas_sociales_completadas / $proyectoEstudiante->proyecto->horas_requeridas) * 100 : 0;
        return view('estudiantes.detallesmio', compact('proyectoEstudiante', 'porcentaje'));
    }

    //retorna vista solicitud de proyecto
    public function Mi_proyecto() 
    { 
        $userId = auth()->user()->id_usuario; 
        $estudiante = Estudiante::where('id_usuario', $userId)->first(); 

        if (!$estudiante) { 
            return redirect()->back()->with('warning', 'Estudiante no encontrado.'); 
        } 

        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', $estudiante->id_estudiante) 
            ->with('proyecto') 
            ->first(); 

        if (!$proyectoEstudiante || !$proyectoEstudiante->proyecto) { 
            return redirect()->back()->with('warning', 'No posee proyecto asignado.'); 
        } 

        // Usar las horas del estudiante
        $horasCompletadas = $estudiante->horas_sociales_completadas ?? 0;
        $horasTotales = $proyectoEstudiante->proyecto->horas_requeridas ?? 1;

        // Calcula el porcentaje
        $porcentaje = $horasTotales > 0 
            ? round(($horasCompletadas / $horasTotales) * 100, 2)
            : 0;

        return view('estudiantes.proyectomio', compact('proyectoEstudiante', 'porcentaje', 'horasCompletadas', 'horasTotales')); 
    }

    /*public function Solicitud_Proyecto_Student()
    {
        $estudianteId = auth()->user()->id_usuario;

        $estudiante = Estudiante::where('id_usuario', $estudianteId)->first();
        
        if ($estudiante) {
            $tieneProyecto = ProyectosEstudiantes::where('id_estudiante', $estudiante->id_estudiante)
                ->exists();
                if ($tieneProyecto) {
                    return redirect()->back()->with('warning', 'Este estudiante ya tiene un proyecto asignado.');
                }
                

            $seccion_id = $estudiante->id_seccion;
            $proyectoEstudiante = Estudiante::where('id_seccion', $seccion_id)->first();
            
            return view('estudiantes.solicitud-proyecto', compact('proyectoEstudiante'));
        }  
    }*/
    public function Solicitud_Proyecto_Student()
{
    $estudianteId = auth()->user()->id_usuario;

    // Obtener el estudiante autenticado
    $estudiante = Estudiante::where('id_usuario', $estudianteId)->first();
    
    if ($estudiante) {
        // Verificar si el estudiante ya tiene un proyecto asignado
        $proyectoEstudiante = ProyectosEstudiantes::where('id_estudiante', $estudiante->id_estudiante)->first();

        if ($proyectoEstudiante) {
            // Verificar si el estado del proyecto es 9
            if ($proyectoEstudiante->estado == 7) {
                return view('estudiantes.solicitud-proyecto', compact('proyectoEstudiante'));
            } else {
                return redirect()->back()->with('warning', 'No se puede enviar el proyecto, ya enviaste una solicitud.');
            }
        }

        // Si no tiene un proyecto asignado
        $seccion_id = $estudiante->id_seccion;
        $proyectoEstudiante = Estudiante::where('id_seccion', $seccion_id)->first();
        
        return view('estudiantes.solicitud-proyecto', compact('proyectoEstudiante'));
    }  

    // Si no se encuentra el estudiante
    return redirect()->back()->with('error', 'No se encontró al estudiante.');
}



    public function Procesos()
    {
        return view('estudiantes.vista_procesos_horas');
    }

    public function docs()
    {
        return view('estudiantes.docs_tramites');
    }


}
