<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proyectos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Proyectos</h1>
    <table>
        <thead>
            <tr>
                <th>Título del Proyecto</th>
                <th>Estudiantes</th>
                <th>Tutor</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Finalización</th>
                <th>Ubicación</th>
                <th>Progreso</th>
                <th>Estado</th>
                <th>Sección/Departamento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proyectosData as $proyecto)
                <tr>
                    <td>{{ $proyecto->nombre_proyecto }}</td>
                    <td>
                        @if($proyecto->estudiantes->isNotEmpty())
                            @foreach($proyecto->estudiantes as $estudiante)
                                {{ $estudiante->usuario->name }},
                            @endforeach
                        @else
                            No hay estudiantes asignados
                        @endif 
                    </td>
                    <td>{{ $proyecto->tutorr?->name ?? 'Sin tutor asignado' }}</td>
                    <td>{{ $proyecto->fecha_inicio }}</td>
                    <td>{{ $proyecto->fecha_fin }}</td>
                    <td>{{$proyecto->lugar}}</td>
                    <td>-</td>
                    <td>{{ $proyecto->estadoo->nombre_estado }}</td>
                    <td>{{$proyecto->seccion->nombre_seccion}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
