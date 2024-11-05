<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class DepartamentosExport implements FromCollection, ShouldAutoSize,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //test con json
        $json = file_get_contents(storage_path('app/public/departamentos.json'));
        $data = json_decode($json, true);

        return collect($data);

        //return Departamento::all();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre Departamento',
        ];
    }
}
