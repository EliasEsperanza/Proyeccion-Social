<?php

namespace App\Exports;

use App\Models\Estudiante;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class EstudianteExport implements FromView,WithColumnWidths
{
   

    public function columnWidths(): array
    {
        return [
            'ID Estudiante' => 100,
            'Nombre Estudiante' => 100,  
            'ID Seccion' => 100,
            'Nombre Seccion' => 100,           
            'Horas Sociales Completadas' => 100,
            'Porcentaje Completado' =>100,

        ];
    }
    
    public function view(): View
    {
        $estudiantes=Estudiante::all();
        return view('exports.estudiantesExcel', [
            'estudiantes' => $estudiantes
        ]);
    }
}
