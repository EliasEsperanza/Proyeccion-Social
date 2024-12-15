<?php

namespace App\Http\Controllers;

use App\Exports\ProyectosExport;
use App\Models\Proyecto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ReportesProyectosController extends Controller
{

    private function generarPDF($proyectos)
    {
        $proyectosData = Proyecto::with(['estudiantes.usuario', 'tutorr', 'estadoo', 'seccion'])
            ->whereIn('id_proyecto', $proyectos)
            ->get();
        $pdf = Pdf::loadView('proyecto.pdf', compact('proyectosData'))->setPaper('a4', 'landscape');
        return $pdf->download('proyectos_' . date('Y-m-d') . '.pdf');
    }

    public function generarInforme()
    {
        $proyectos = Proyecto::all();
        $pdf = Pdf::loadView('test', compact('proyectos'));
        return $pdf->download('informe_progreso.pdf');
    }

    private function generarExcel($proyectos)
    {
        return Excel::download(new ProyectosExport($proyectos), 'proyectos_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
