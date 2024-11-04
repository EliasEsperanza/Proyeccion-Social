<?php

namespace App\Http\Controllers;

use App\Models\ProyectosDocumentos;
use Illuminate\Http\Request;

class ProyectosDocumentosController extends Controller
{
    #metodo para mostrar todas los proyectos_documentos en una vista
    public function index()
    {
        $ProyectosDocumentoss = ProyectosDocumentos::all();
        return view('proyectos_documentos.index', compact('ProyectosDocumentoss'));
    }

    #metodo para  crear un nuevo proyecto_documento
    public function create()
    {
        return view('proyectos_documentos.create');
    }

    #metodo para guardar
    public function store(Request $request)
    {
        $request->validate([
            'id_documento' => 'required|integer|exists:documentos,id',
            'id_proyecto' => 'required|integer|exists:proyectos,id_proyecto',
        ]);

        ProyectosDocumentos::create($request->all());
        return redirect()->route('proyectos_documentos.index')
                         ->with('success', 'ProyectosDocumentos creado exitosamente.');
    }

    #metodo para mostrar un proyecto_documento en una vista
    public function show($id)
    {
        $ProyectosDocumentos = ProyectosDocumentos::find($id);
        return view('proyectos_documentos.show', compact('ProyectosDocumentos'));
    }

    #metodo para editar un proyecto_documento
    public function edit($id)
    {
        $ProyectosDocumentos = ProyectosDocumentos::find($id);
        return view('proyectos_documentos.edit', compact('ProyectosDocumentos'));
    }

    #metodo para actualizar un proyecto_documento
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_documento' => 'required|integer|exists:documentos,id',
            'id_proyecto' => 'required|integer|exists:proyectos,id_proyecto',
        ]);

        $ProyectosDocumentos = ProyectosDocumentos::find($id);
        $ProyectosDocumentos->update($request->all());
        return redirect()->route('proyectos_documentos.index')
                         ->with('success', 'ProyectosDocumentos actualizado exitosamente.');
    }

    #metodo para eliminar un proyecto_documento
    public function destroy($id)
    {
        $ProyectosDocumentos = ProyectosDocumentos::find($id);
        $ProyectosDocumentos->delete();
        return redirect()->route('proyectos_documentos.index')
                         ->with('success', 'ProyectosDocumentos eliminado exitosamente.');
    }
}
