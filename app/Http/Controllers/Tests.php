<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Tests extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $departamentosPath = storage_path('app/public/departamentos.json');
        if (!file_exists($departamentosPath)) {
            file_put_contents($departamentosPath, json_encode([]));
        }
        
        $json = file_get_contents($departamentosPath);
        $departamentos = json_decode($json, true);

        $usuariosPath = storage_path('app/public/Usuarios.json');
        if (!file_exists($usuariosPath)) {
            file_put_contents($usuariosPath, json_encode([]));
        }

        $json = file_get_contents($usuariosPath);
        $usuarios = json_decode($json, true);

        $historialDepartamentosPath = storage_path('app/public/Historial_departamentos.json');
        if (!file_exists($historialDepartamentosPath)) {
            file_put_contents($historialDepartamentosPath, json_encode([]));
        }
        
        $json = file_get_contents($historialDepartamentosPath);
        $historial_departamentos = json_decode($json, true);

        return view('Kev.Tests', compact('departamentos', 'usuarios', 'historial_departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
