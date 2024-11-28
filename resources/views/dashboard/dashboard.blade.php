@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="contenedorPrincipal">
    <div class="contenedorPrincipal__titulo">
        <h1>Dashboard</h1>
    </div>
    
    <div class="informacion">
        <div class="informacion__estudiantes">
            <h3>Total Estudiantes</h3>
            <p>
                @if(Auth::user()->hasRole('Coordinador'))
                    Todos los estudiantes en la sección del coordinador
                @elseif(Auth::user()->hasRole('Tutor'))
                    Estudiantes asignados a este tutor
                @else
                    Todos los estudiantes registrados en el sistema
                @endif
            </p>
            <h2>{{ $totalEstudiantes }}</h2>
        </div>

        <div class="informacion__proyectos">
            <h3>Cantidad de proyectos</h3>
            <p>
                @if(Auth::user()->hasRole('Tutor'))
                    Todos los proyectos asignados a este tutor
                @elseif(Auth::user()->hasRole('Coordinador'))
                    Todos los proyectos disponibles para el coordinador
                @else
                    Total proyectos registrados en el sistema
                @endif
            </p>
            <h2>{{ $totalProyectosAsignados }}</h2>
        </div>

        @if(Auth::user()->hasRole('Coordinador'))
            <div class="informacion__asesores">
                <h3>Coordinadores</h3>
                <p>Total de coordinadores</p>
                <h2>{{ $totalCoordinadores }}</h2>
            </div>
        @elseif(Auth::user()->hasRole('Tutor'))
        @else
            <div class="informacion__asesores">
                <h3>Tutores</h3>
                <p>Total de tutores</p>
                <h2>{{ $totalTutores }}</h2>
            </div>
        @endif
    </div>

    <div class="graficos">
        <div class="graficos__Estado card" style="width: 50%; float: left;">
            <canvas id="estadoProyectosChart"></canvas>
        </div>
        <div class="graficos__Fecha card" style="width: 50%; float: left;">
            <canvas id="estadoProyectosChart2"></canvas>
        </div>
    </div>
    <div style="clear: both;"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctxEstado = document.getElementById('estadoProyectosChart').getContext('2d');
        fetch('{{ route("dashboard.datosGrafico") }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener los datos');
                }
                return response.json();
            })
            .then(data => {
                new Chart(ctxEstado, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Cantidad de Proyectos',
                            data: data.data,
                            backgroundColor: ['#36A2EB', '#4BC0C0', '#FFCE56', '#FF6384'],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: { display: true, text: 'Estado de Proyectos' },
                            legend: { display: false }
                        },
                        scales: {
                            x: { title: { display: true, text: 'Estados de Proyectos' } },
                            y: { beginAtZero: true, title: { display: true, text: 'Cantidad' } }
                        }
                    }
                });
            })
            .catch(error => console.error('Error al cargar los datos del gráfico:', error));

        const ctxFecha = document.getElementById('estadoProyectosChart2').getContext('2d');
        fetch('{{ route("dashboard.estudiantesProyectosPorFecha") }}')
            .then(response => response.json())
            .then(data => {
                const fechas = data.map(item => item.fecha);
                const estudiantes = data.map(item => item.total_estudiantes);
                const proyectos = data.map(item => item.total_proyectos);

                new Chart(ctxFecha, {
                    type: 'bar',
                    data: {
                        labels: fechas,
                        datasets: [
                            {
                                type: 'line',
                                label: 'Estudiantes',
                                data: estudiantes,
                                borderColor: '#8e44ad',
                                backgroundColor: 'rgba(142, 68, 173, 0.2)',
                                fill: true,
                                tension: 0.4
                            },
                            {
                                type: 'bar',
                                label: 'Proyectos',
                                data: proyectos,
                                backgroundColor: '#1abc9c',
                                borderColor: '#16a085',
                                borderWidth: 1
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: { display: true, text: 'Estudiantes y Proyectos por Fecha' },
                            legend: { position: 'bottom' }
                        },
                        scales: {
                            x: { title: { display: true, text: 'Fechas' } },
                            y: { beginAtZero: true, title: { display: true, text: 'Cantidad' } }
                        }
                    }
                });
            })
            .catch(error => console.error('Error al cargar los datos del gráfico:', error));
    });
</script>
@endsection