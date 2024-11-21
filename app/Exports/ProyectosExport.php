<?php

namespace App\Exports;

use App\Models\Proyecto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProyectosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $proyectosIds;

    public function __construct(array $proyectosIds)
    {
        $this->proyectosIds = $proyectosIds;
    }

    public function collection()
    {
        return Proyecto::with(['estudiantes.usuario', 'tutorr', 'estadoo', 'seccion'])
            ->whereIn('id_proyecto', $this->proyectosIds)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Numero',
            'Nombre Proyecto',
            'Estudiantes',
            'Tutor',
            'Fecha Inicio',
            'Fecha Fin',
            'Lugar',
            'Sección',
            'Estado',
            'Finalizado'
        ];
    }

    public function map($proyecto): array
    {
        return [
            $proyecto->id_proyecto,
            $proyecto->nombre_proyecto,
            $this->formatEstudiantes($proyecto->estudiantes),
            $proyecto->tutorr?->name ?? 'Sin tutor asignado',
            $proyecto->fecha_inicio,
            $proyecto->fecha_fin,
            $proyecto->lugar,
            $proyecto->seccion->nombre_seccion,
            $proyecto->estadoo->nombre_estado,
            $this->isFinalizado($proyecto->estadoo->nombre_estado),
        ];
    }

    private function formatEstudiantes($estudiantes)
    {
        if ($estudiantes->isEmpty()) {
            return 'No hay estudiantes asignados';
        }

        return $estudiantes->map(function ($estudiante) {
            return $estudiante->usuario->name;
        })->join("\n");
    }

    public function styles(Worksheet $sheet)
    {
        // Número total de filas
        $rowCount = $sheet->getHighestRow();
        
        $styles = [];
    
        // Encabezado
        $styles[1] = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center'],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'FFFFFF'],
            ],
        ];
    
        // Alternar colores para las filas de contenido
        for ($row = 2; $row <= $rowCount; $row++) {
            $finalizado = $sheet->getCell('J' . $row)->getValue();
            $styles[$row] = [
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => $row % 2 == 0 ? 'D9EAD3' : 'FFFFFF', 
                    ],
                ],
                'alignment' => [
                    'vertical' => 'top',
                    'wrapText' => true,
                ],
            ];
            // Si el valor de la celda es "Sí", aplicar fondo amarillo
            if (strtolower($finalizado) === 'sí') {
                $styles['J' . $row] = [
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'FFFF00'],
                    ],
                    'alignment' => [
                        'vertical' => 'top',
                        'wrapText' => true,
                    ],
                ];
            }
        }
    
        return $styles;
    }
    private function isFinalizado($estado)
    {
        return strtolower($estado) === 'finalización (memoria)' ? 'Sí' : 'No';
    }
    
}