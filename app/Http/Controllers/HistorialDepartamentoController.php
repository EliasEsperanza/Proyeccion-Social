<?php
namespace App\Http\Controllers;

use App\Models\historial_departamento;
use Illuminate\Http\Request;
use App\Models\HistorialDepartamento;

class HistorialDepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historial = historial_departamento::all();
        return view('historial_departamentos.index', compact('historial'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('historial_departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_departamento' => 'required|exists:departamentos,id_departamento',
            'accion' => 'required|string|max:255',
            'nombre_departamento' => 'nullable|string|max:255',
        ]);

        historial_departamento::create($request->all());

        return redirect()->route('historial_departamentos.index')->with('success', 'Registro de historial creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $historial = historial_departamento::findOrFail($id);
        return view('historial_departamentos.show', compact('historial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $historial = historial_departamento::findOrFail($id);
        return view('historial_departamentos.edit', compact('historial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_departamento' => 'required|exists:departamentos,id_departamento',
            'accion' => 'required|string|max:255',//si se modifica, rechazo o aprobo 
            'nombre_departamento' => 'nullable|string|max:255',
        ]);

        $historial = historial_departamento::findOrFail($id);
        $historial->update($request->all());

        return redirect()->route('historial_departamentos.index')->with('success', 'Registro de historial actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $historial = historial_departamento::findOrFail($id);
        $historial->delete();

        return redirect()->route('historial_departamentos.index')->with('success', 'Registro de historial eliminado exitosamente.');
    }
}