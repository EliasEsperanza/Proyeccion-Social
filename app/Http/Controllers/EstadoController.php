<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ListEstados = Estado::all();
        return view("estado.index", compact("ListEstados")); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("estado.create"); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_estado' => 'required|string|max:50',
        ]);

        $proyecto = Estado::crearProyecto($data);
        return response()->json($proyecto, 201);    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estado = Estado::find($id);
        return view("estado.show", compact('estado')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estado = Estado::find($id); 

        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404);
        }
        return view("", compact('estado')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre_estado' => 'required|string|max:50',
        ]);
    
        $estado = Estado::find($id);
    
        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404);
        }
    
        $estado->update($data);
        return response()->json($estado, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estado = Estado::find($id);
        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404);
        }
        
        $estado->delete(); 
        return response()->json(['message' => 'Estado eliminado con éxito'], 200);
    }
}