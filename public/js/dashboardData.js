
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
                            backgroundColor: [
                                '#36A2EB',
                                '#4BC0C0',
                                '#FFCE56', 
                                '#FF6384'
                            ],
                            borderColor: '#fff',
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
                                display: false 
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Estados de Proyectos'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cantidad'
                                }
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
                            title: {
                                display: true,
                                text: 'Estudiantes y Proyectos por Fecha'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Fechas'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cantidad'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error al cargar los datos del gráfico:', error);
            });
    });