<?php

namespace App\Http\Controllers;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepartamentoController extends Controller
{
    /**
     * Muestra una lista de los departamentos.
     */
    public function index(Request $request): View
    {
        $departamentos = Departamento::paginate(20);

        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Muestra el formulario para crear un nuevo departamento.
     */
    public function create(): View
    {
        $departamento = new Departamento();
        return view('departamentos.create', compact('departamento'));
    }

    /**
     * Guarda un nuevo departamento en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_departamento' => 'required|string|max:60',
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index');
    }

    /**
     * Muestra los detalles de un departamento específico.
     */
    public function show($id): View
    {
        // Buscamos un departamento por su ID.
        $departamento = Departamento::find($id);

        return view('departamentos.show', compact('departamento'));
    }

    /**
     * Muestra el formulario para editar un departamento existente.
     */
    public function edit($id): View
    {
        // Buscamos un departamento por su ID.
        $departamento = Departamento::find($id);

        return view('departamentos.edit', compact('departamento'));
    }

    /**
     * Actualiza un departamento en la base de datos.
     */
    public function update(Request $request, Departamento $departamento): RedirectResponse
    {
        $request->validate([
            'nombre_departamento' => 'required|string|max:60',
        ]);

        $departamento->update($request->all());

        return redirect()->route('departamentos.index');
    }

    /**
     * Elimina un departamento de la base de datos.
     */
    public function destroy($id): RedirectResponse
    {
        // Buscamos un departamento por su ID.
        $departamento = Departamento::find($id);
        $departamento->delete();

        return redirect()->route('departamentos.index');
    }
}
