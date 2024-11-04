<?php

namespace App\Exports;

use App\Models\Asignacion;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class AsignacionExport implements FromView,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function columnWidths(): array
    {
        return [
            'ID Asignacion' => 100,
            'ID Proyecto' => 100,
            'Nombre Proyecto' => 100,           
            'ID Estudiante' => 100,
            'Nombre Estudiante' => 100,  
            'ID Tutor' => 100,
            'Nombre Tutor' =>100,
            'Fecha Asignacion' =>100,
        ];
    }

    public function view():View
    {
        $asignaciones = Asignacion::all();
        return view('exports.asignacionesExcel', [
            'asignaciones' => $asignaciones
        ]);
    }

}
