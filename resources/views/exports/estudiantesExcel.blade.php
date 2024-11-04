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
                <td style="border:2px solid #000">ID Estudiante</td>
                <td style="border:2px solid #000">Nombre</td>
                <td style="border:2px solid #000">ID Seccion</td>
                <td style="border:2px solid #000">Nombre Seccion</td>
                <td style="border:2px solid #000">Horas Sociales Completadas</td>
                <td style="border:2px solid #000">Porcentaje Completado</td>
        
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantes as $estudiante)
                <tr>
                    <td style="border:2px solid #000">{{$estudiante->id_estudiante}}</td>
                    <td style="border:2px solid #000">{{$estudiante->usuario->nombre}}</td>
                    <td style="border:2px solid #000">{{$estudiante->id_seccion}}</td>
                    <td style="border:2px solid #000">{{$estudiante->seccion->nombre_seccion}}</td>
                    <td style="border:2px solid #000">{{$estudiante->horas_sociales_completadas}}</td>
                    <td style="border:2px solid #000">{{$estudiante->porcentaje_completado}}</td>
                </tr>
            @endforeach

        </tbody>
</body>
</html>