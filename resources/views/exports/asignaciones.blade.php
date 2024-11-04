<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <table style="border:2px solid #000">
        <thead>
            <tr>
                <td style="border:2px solid #000">ID Asignacion</td>
                <td style="border:2px solid #000">ID Proyecto</td>
                <td style="border:2px solid #000">Nombre Proyecto</td>
                <td style="border:2px solid #000">ID Estudiante</td>
                <td style="border:2px solid #000">Nombre Estudiante</td>
                <td style="border:2px solid #000">ID Tutor</td>
                <td style="border:2px solid #000">Nombre Tutor</td>
                <td style="border:2px solid #000">Fecha Asignacion</td>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaciones as $asignacion)
                <tr>
                    <td style="border:2px solid #000">{{ $asignacion->id_asignacion }}</td>
                    <td style="border:2px solid #000">{{ $asignacion->id_proyecto }}</td>
                    <td style="border:2px solid #000">{{ $asignacion->proyecto->nombre_proyecto }}</td>
                    <td style="border:2px solid #000">{{ $asignacion->id_estudiante }}</td>
                    <td style="border:2px solid #000">{{ $asignacion->estudiante->usuario->nombre }}</td>
                    <td style="border:2px solid #000">{{ $asignacion->id_tutor }}</td>
                    <td style="border:2px solid #000">{{ $asignacion->usuario->nombre }}</td>
                    <td style="border:2px solid #000">{{ $asignacion->fecha_asignacion }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    
</body>
</html>
