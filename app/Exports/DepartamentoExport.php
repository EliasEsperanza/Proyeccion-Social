<?php

namespace App\Exports;

use App\Models\Departamento;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DepartamentoExport implements FromCollection,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Departamento::all();
    }
}
