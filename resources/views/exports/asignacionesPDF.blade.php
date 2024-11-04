<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1 style="text-align: center; margin:10px;">Asignaciones</h1>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <td>ID Asignacion</td>
                <td>ID Proyecto</td>
                <td>Nombre Proyecto</td>
                <td>ID Estudiante</td>
                <td>Nombre Estudiante</td>
                <td>ID Tutor</td>
                <td>Nombre Tutor</td>
                <td>Fecha Asignacion</td>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaciones as $asignacion)
                <tr>
                    <td>{{ $asignacion->id_asignacion }}</td>
                    <td>{{ $asignacion->id_proyecto }}</td>
                    <td>{{ $asignacion->proyecto->nombre_proyecto }}</td>
                    <td>{{ $asignacion->id_estudiante }}</td>
                    <td>{{ $asignacion->estudiante->usuario->nombre }}</td>
                    <td>{{ $asignacion->id_tutor }}</td>
                    <td>{{ $asignacion->usuario->nombre }}</td>
                    <td>{{ $asignacion->fecha_asignacion }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    
</body>
</html>
