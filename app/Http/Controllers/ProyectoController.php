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
        return view("Proyecto.CreateProyecto");
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
    
        $proyecto = Proyecto::crearProyecto($data);
        return response()->json($proyecto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proyecto = Proyecto::find($id);
        return view('Proyecto.ShowProyecto', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proyecto = Proyecto::find($id); 

        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }
        return view("Proyecto.EditProyecto", compact('proyecto')); 
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
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }
    
        $proyecto->update($data);
        return response()->json($proyecto, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }
        
        $proyecto->delete(); 
        return response()->json(['message' => 'Proyecto eliminado con éxito'], 200);
    }
}