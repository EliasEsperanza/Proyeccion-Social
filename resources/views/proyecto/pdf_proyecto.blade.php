<!DOCTYPE html>
<html>
<head>
    <title>Detalles del proyecto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        .info-container {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .info-container h2 {
            color: #555;
            margin-top: 0;
            margin-bottom: 10px;
        }
        
        .info-container p {
            color: #777;
            margin-bottom: 5px;
        }
        
        .info-container .label {
            font-weight: bold;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h1>{{ $proyecto->nombre_proyecto }}</h1>
    
    <div class="info-container">
        <h2>Descripción</h2>
        <p>{{ $proyecto->descripcion_proyecto }}</p>
    </div>
    
    <div class="info-container">
        <h2>Detalles</h2>
        <p><span class="label">Horas requeridas:</span> {{ $proyecto->horas_requeridas }}</p>
        <p>
    <span class="label">Ubicación:</span>
    {{ $proyecto->lugar }}
</p>

<p>
    <span class="label">Departamento:</span>
    @if ($proyecto->seccion)
        {{ $proyecto->seccion->nombre_seccion }}
    @else
        <span class="text-muted">No asignado</span>
    @endif
</p>
    </div>
</body>
</html>