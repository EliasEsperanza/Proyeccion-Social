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
            'ID Asignacion' => 25,
            'ID Proyecto' => 25,
            'Nombre Proyecto' => 55,           
            'ID Estudiante' => 25,
            'Nombre Estudiante' => 55,  
            'ID Tutor' => 25,
            'Nombre Tutor' =>55,
            'Fecha Asignacion' =>50,

        ];
    }

    public function view():View
    {
        $asignaciones=Asignacion::all();
        return view('exports.asignaciones', [
            'asignaciones' => $asignaciones
        ]);
    }

}
