<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        #Filtro por nombre de estado
        $query = Estado::query();
        if ($request->filled('nombre')) {
            $query->where('nombre_estado', 'like', '%' . $request->nombre . '%');
        }
        $ListEstados = $query->get();
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

        // Estandarización del nombre
        $data['nombre_estado'] = ucfirst(strtolower($data['nombre_estado'])); #usamos ucfirst y strtolower para convertir la primera letra a mayúscula y las demás a minúsculas, estandarizando el formato.

        Estado::crearEstado($data);
        return redirect()->route('estado.index')->with('success', 'Estado creado con éxito');
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
            return redirect()->route('estado.index')->with('error', 'Estado no encontrado');
        }
        return view("estado.edit", compact('estado'));
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
            return redirect()->route('estado.index')->with('error', 'Estado no encontrado');
        }

        // Estandarización del nombre
        $data['nombre_estado'] = ucfirst(strtolower($data['nombre_estado'])); #usamos ucfirst y strtolower para convertir la primera letra a mayúscula y las demás a minúsculas, estandarizando el formato.

        $estado->update($data);
        return redirect()->route('estado.index')->with('success', 'Estado actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estado = Estado::find($id);
        if (!$estado) {
            return redirect()->route('estado.index')->with('error', 'Estado no encontrado');
        }

        $estado->delete();
        return redirect()->route('estado.index')->with('success', 'Estado eliminado con éxito');
    }
}
