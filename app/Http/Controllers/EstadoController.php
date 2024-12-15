<?php

namespace App\Http\Controllers;

use App\Http\Requests\Estado\StoreRequest;
use App\Http\Requests\Estado\UpdateRequest;
use App\Models\Estado;
use App\Models\HistorialEstado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    private $transiciones = [
        'pendiente' => ['en_proceso', 'cancelado', 'rechazado'],
        'en_proceso' => ['completado', 'cancelado', 'rechazado'],
        'completado' => [],
        'cancelado' => [],
        'rechazado' => []
    ];

    /**
     * Verificar si una transición de estado es válida.
     */
    private function puedeTransicionar($estadoActual, $nuevoEstado)
    {
        return in_array($nuevoEstado, $this->transiciones[$estadoActual]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filtro por nombre de estado
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

    public function store(StoreRequest $request)
    {

        // Estandarización del nombre
        $request['nombre_estado'] = ucfirst(strtolower($request['nombre_estado']));

        Estado::create($request->all());
        return redirect()->route('estado.index')->with('success', 'Estado creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $estado = Estado::find($id);
        return view("estado.show", compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estado = Estado::find($id);

        if (!$estado) {
            return redirect()->route('estado.index')->with('error', 'Estado no encontrado');
        }
        return view("estado.edit", compact('estado'))->with('success', 'Estado encontrado');
    }

    /**
     * Show the form for changing the state.
     */
    public function mostrarCambiarEstado($id)
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
    //form request a probar
    public function update(UpdateRequest $request, $id)
    {
        $estado = Estado::find($id);

        if (!$estado) {
            return redirect()->route('estado.index')->with('error', 'Estado no encontrado');
        }
/////////////////////////////

        $estadoAnterior = $estado->nombre_estado;

        $request->validate([
            'nuevo_estado' => 'required|string|in:' . implode(',', $this->transiciones[$estadoAnterior] ?? []),
        ]);

        $nuevoEstado = $request->input('nuevo_estado');

        if ($this->puedeTransicionar($estadoAnterior, $nuevoEstado)) {
            $estado->nombre_estado = $nuevoEstado;
            $estado->save();

            HistorialEstado::create([
                'proyecto_id' => $estado->proyecto_id,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $nuevoEstado,
            ]);

            return redirect()->route('estado.index')->with('success', 'Estado actualizado con éxito');
        }

        return redirect()->route('estado.index')->with('error', 'Transición de estado no permitida');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $estado = Estado::find($id);
        if (!$estado) {
            return redirect()->route('estado.index')->with('error', 'Estado no encontrado');
        }

        $estado->delete();
        return redirect()->route('estado.index')->with('success', 'Estado eliminado con éxito');
    }
}

