<?php

namespace App\Http\Controllers;

use App\Models\Seccion; 
use App\Models\Departamento; 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeccionController extends Controller 
{
    /**
     * Muestra una lista de las secciones.
     */
    public function index(Request $request): View
    {
        $secciones = Seccion::paginate(20); 

        return view('secciones.index', compact('secciones'));
    }

    /**
     * Muestra el formulario para crear una nueva sección.
     */
    public function create(): View
    {
        $seccion = new Seccion(); 
        $departamentos = Departamento::all(); 
        return view('secciones.create', compact('seccion', 'departamentos'));
    }

    /**
     * Guarda una nueva sección en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_seccion' => 'required|string|max:255',
            'id_departamento' => 'required|exists:departamentos,id_departamento',
        ]);

        Seccion::create($request->all()); 

        return redirect()->route('secciones.index');
    }

    /**
     * Muestra los detalles de una sección específica.
     */
    public function show($id): View
    {
        // Buscamos una sección por su ID o lanzamos 404 si no existe.
        $seccion = Seccion::findOrFail($id);

        return view('secciones.show', compact('seccion'));
    }

    /**
     * Muestra el formulario para editar una sección existente.
     */
    public function edit($id): View
    {
        // Buscamos una sección por su ID o lanzamos 404 si no existe.
        $seccion = Seccion::findOrFail($id);
        $departamentos = Departamento::all(); 

        return view('secciones.edit', compact('seccion', 'departamentos'));
    }

    /**
     * Actualiza una sección en la base de datos.
     */
    public function update(Request $request, Seccion $seccion): RedirectResponse
    {
        $request->validate([
            'nombre_seccion' => 'required|string|max:255',
            'id_departamento' => 'required|exists:departamentos,id_departamento',
        ]);

        $seccion->update($request->all()); 

        return redirect()->route('secciones.index');
    }

    /**
     * Elimina una sección de la base de datos.
     */
    public function destroy($id): RedirectResponse
    {
        // Buscamos una sección por su ID o lanzamos 404 si no existe.
        $seccion = Seccion::findOrFail($id);
        $seccion->delete();

        return redirect()->route('secciones.index');
    }
}
