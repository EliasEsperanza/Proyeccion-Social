<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/pdf_proyectos.css') }}">
</head>

<body>
    <div class="project-header">
        <h1>{{ $proyecto->nombre_proyecto }}</h1>
    </div>

    <div class="info-container">
        <h2>
            <i class="fas fa-align-left detail-icon"></i>
            Descripción
        </h2>
        <p>{!! $proyecto->descripcion_proyecto !!}</p>
    </div>

    <div class="info-container">
        <h2>
            <i class="fas fa-info-circle detail-icon"></i>
            Detalles del Proyecto
        </h2>
        <div class="detail-item">
            <i class="fas fa-clock detail-icon"></i>
            <div class="detail-content">
                <span class="detail-label">Horas requeridas:</span>
                <span class="detail-value">{{ $proyecto->horas_requeridas }}</span>
            </div>
        </div>

        <div class="detail-item">
            <i class="fas fa-map-marker-alt detail-icon"></i>
            <div class="detail-content">
                <span class="detail-label">Ubicación:</span>
                <span class="detail-value">{{ $proyecto->lugar }}</span>
            </div>
        </div>

        <div class="detail-item">
            <i class="fas fa-building detail-icon"></i>
            <div class="detail-content">
                <span class="detail-label">Departamento:</span>
                @if ($proyecto->seccion)
                <span class="detail-value">{{ $proyecto->seccion->nombre_seccion }}</span>
                @else
                <span class="detail-value muted">No asignado</span>
                @endif
            </div>
        </div>
    </div>
</body>

</html>