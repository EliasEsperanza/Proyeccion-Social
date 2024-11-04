<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1 style="text-align: center; margin:10px;">Estudiantes</h1>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <td>ID Estudiante</td>
                <td>Nombre</td>
                <td>ID Seccion</td>
                <td>Nombre Seccion</td>
                <td>Horas Sociales Completadas</td>
                <td>Porcentaje Completado</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $estudiante)
                <tr>
                    <td>{{$estudiante->id_estudiante}}</td>
                    <td>{{$estudiante->usuario->nombre}}</td>
                    <td>{{$estudiante->id_seccion}}</td>
                    <td>{{$estudiante->seccion->nombre_seccion}}</td>
                    <td>{{$estudiante->horas_sociales_completadas}}</td>
                    <td>{{$estudiante->porcentaje_completado}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>