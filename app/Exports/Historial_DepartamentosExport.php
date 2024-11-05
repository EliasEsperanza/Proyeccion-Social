<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Historial_DepartamentosExport    implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //test con json
        $json = file_get_contents(storage_path('app/public/Historial_departamentos.json'));
        $data = json_decode($json, true);

        return collect($data);

        //return Historial_Departamentos::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['ID', 'Accion', 'Nombre departamento'];
    }
}

