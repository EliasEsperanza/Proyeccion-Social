<?php

namespace App\Http\Controllers;

use App\Exports\Historial_DepartamentosExport;
use App\Models\Historial_Departamentos;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class historial_departamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historial = Historial_Departamentos::all();
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

        Historial_Departamentos::create($request->all());

        return redirect()->route('historial_departamentos.index')->with('success', 'Registro de historial creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $historial = Historial_Departamentos::findOrFail($id);
        return view('Historial_Departamentoss.show', compact('historial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $historial = Historial_Departamentos::findOrFail($id);
        return view('historial_departamentos.edit', compact('historial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_departamento' => 'required|exists:departamentos,id_departamento',
            'accion' => 'required|string|max:255', //si se modifica, rechazo o aprobo 
            'nombre_departamento' => 'nullable|string|max:255',
        ]);

        $historial = Historial_Departamentos::findOrFail($id);
        $historial->update($request->all());

        return redirect()->route('historial_departamentos.index')->with('success', 'Registro de historial actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $historial = Historial_Departamentos::findOrFail($id);
        $historial->delete();

        return redirect()->route('historial_departamentos.index')->with('success', 'Registro de historial eliminado exitosamente.');
    }

    //export a excel/pdf
    public function exportarAllHistorialDepartamentos_Excel()
    {
        return Excel::download(new Historial_DepartamentosExport, 'Historial_Departamentos.xlsx');
    }

    public function exportarAllHistorialDepartamentos_Pdf()
    {
        return Excel::download(new Historial_DepartamentosExport, 'Historial_Departamentos.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
