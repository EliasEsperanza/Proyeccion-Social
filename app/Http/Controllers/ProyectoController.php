<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ListProyecto = Proyecto::all();
        return view("Proyecto.indexProyecto", compact("ListProyecto"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Proyecto.createProyecto");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'estado' => 'required|integer',
            'periodo' => 'required|string|max:255',
            'lugar' => 'required|string|max:255',
            'coordinador' => 'required|integer',
        ]);
    
        Proyecto::crearProyecto($data);
        return redirect()->route('proyecto.index')->with('success', 'Proyecto creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proyecto = Proyecto::find($id);
        return view('Proyecto.showProyecto', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proyecto = Proyecto::find($id); 

        if (!$proyecto) {
            return redirect()->route('proyecto.index')->with('error', 'Proyecto no encontrado');
        }
        return view("Proyecto.editProyecto", compact('proyecto')); 
    }

    /**
     * Update the specified resource in storage.
     */
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
            return redirect()->route('proyecto.index')->with('error', 'Proyecto no encontrado');
        }
    
        $proyecto->update($data);
        return redirect()->route('proyecto.index')->with('success', 'Proyecto actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return redirect()->route('proyecto.index')->with('error', 'Proyecto no encontrado');
        }
        
        $proyecto->delete(); 
        return redirect()->route('proyecto.index')->with('success', 'Proyecto eliminado con éxito');
    }

    public function filtrarProyectos(Request $request)
    {   
   
        $estado = $request->input('estado');
        $periodo = $request->input('periodo');
        $query = Proyecto::with('estado', 'coordinador'); 
    
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
        $id = (int) $id;

        $data = $request->validate([
            'coordinador' => 'required|integer|exists:usuarios,id',
        ]);

        $proyecto = Proyecto::find($id);
            if (!$proyecto) {
            return redirect()->route('proyecto.index')->with('error', 'Proyecto no encontrado');
        }

        $proyecto->update(['coordinador' => $data['coordinador']]);
        return redirect()->route('proyecto.index')->with('success', 'Responsable asignado con exito');
    }

}
