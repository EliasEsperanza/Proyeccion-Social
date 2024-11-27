<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #b71c1c;
            --secondary-color: #d32f2f;
            --background-color: #f5f5f5;
            --text-color: #212121;
            --muted-color: #757575;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: var(--background-color);
            color: var(--text-color);
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .project-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .project-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .info-container {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-top: 5px solid var(--primary-color);
        }

        .info-container h2 {
            color: var(--primary-color);
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .detail-item {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }

        .detail-icon {
            margin-right: 15px;
            color: var(--primary-color);
            font-size: 1.5rem;
            width: 40px;
            text-align: center;
        }

        .detail-content {
            flex-grow: 1;
        }

        .detail-label {
            font-weight: bold;
            color: var(--primary-color);
            margin-right: 10px;
        }

        .detail-value {
            color: var(--text-color);
        }

        .detail-value.muted {
            color: var(--muted-color);
            font-style: italic;
        }

        @media (max-width: 600px) {
            .detail-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .detail-icon {
                margin-right: 0;
                margin-bottom: 5px;
            }
        }
    </style>
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
        <p>{{ $proyecto->descripcion_proyecto }}</p>
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