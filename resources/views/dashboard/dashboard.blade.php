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
            <p>Todos los estudiantes registrados en el sistema</p>
            <h2>{{ $totalEstudiantes }}</h2>
        </div>

        <div class="informacion__proyectos">
            <h3>Proyectos Activos</h3>
            <p>Proyectos en Curso</p>
            <h2>{{ $totalProyectosActivos }}</h2>
        </div>

        <div class="informacion__asesores">
            <h3>Tutores</h3>
            <p>Total de tutores</p>
            <h2>{{ $totalTutores }}</h2>
        </div>
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
                    type: 'pie',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Estado de Proyectos',
                            data: data.data,
                            backgroundColor: ['#36A2EB', '#4BC0C0', '#FFCE56'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Estado de Proyectos'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error al cargar los datos del gráfico:', error);
            });

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
                                label: 'Estudiantes',
                                data: estudiantes,
                                backgroundColor: '#8e44ad',
                            },
                            {
                                label: 'Proyectos',
                                data: proyectos,
                                backgroundColor: '#1abc9c',
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Estudiantes y Proyectos por Fecha'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error al cargar los datos:', error);
            });
    });
</script>
@endsection
