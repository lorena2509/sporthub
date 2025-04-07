@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center my-4" style="color: white;">📊 Estadísticas de Canchas</h2>

        <div class="charts-wrapper">
            <!-- Gráfica de Total de Reservas -->
            <div class="chart-container">
                <h4 style="color: black;">Total de Reservas por Cancha</h4>
                <canvas id="totalReservasChart" class="chart"></canvas>
            </div>

            <!-- Gráfica Comparativa de Reservadas, Canceladas y Finalizadas -->
            <div class="chart-container">
                <h4 style="color: black;">Comparativa por Cancha: Reservadas, Canceladas y Finalizadas</h4>
                <canvas id="comparativaChart" class="chart"></canvas>
            </div>
        </div>

        <div class="container mt-4">
            <h4 class="text-center" style="color: white;">Resumen de Reservas por Mes</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center;">Mes</th>
                        <th style="text-align: center;">Total Reservas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservasPorMes as $reserva)
                        <tr>
                        <td style="text-align: center;">{{ $reserva['mes'] }}</td>
                        <td style="text-align: center;">{{ $reserva['total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfica Total de Reservas
        var ctx = document.getElementById('totalReservasChart').getContext('2d');
        var totalReservasChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfica: barras
            data: {
                labels: {!! json_encode($canchaNames) !!}, // Nombres de las canchas
                datasets: [{
                    label: 'Total de Reservas',
                    data: {!! json_encode($totalReservas) !!}, // Total de reservas por cancha
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'black', // Set tick color to black
                            stepSize: 1 // Set step size to 1
                        }
                    },
                    x: {
                        ticks: {
                            color: 'black' // Set tick color to black
                        }
                    }
                }
            }
        });

        // Gráfica Comparativa de Reservadas, Canceladas y Finalizadas
        var ctx2 = document.getElementById('comparativaChart').getContext('2d');
        var comparativaChart = new Chart(ctx2, {
            type: 'bar', // Tipo de gráfica: barras
            data: {
                labels: {!! json_encode($canchaNames) !!}, // Nombres de las canchas
                datasets: [
                    {
                        label: 'Reservadas',
                        data: {!! json_encode($reservadas) !!}, // Reservadas por cancha
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Canceladas',
                        data: {!! json_encode($canceladas) !!}, // Canceladas por cancha
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Finalizadas',
                        data: {!! json_encode($finalizadas) !!}, // Finalizadas por cancha
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'black', // Set tick color to black
                            stepSize: 1 // Set step size to 1
                        }
                    },
                    x: {
                        ticks: {
                            color: 'black' // Set tick color to black
                        }
                    }
                }
            }
        });
    </script>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary mt-3">Volver</a>


@endsection

<style>
    /* Estilo para ajustar el tamaño de los gráficos */
    .charts-wrapper {
        display: flex; /* Use flexbox to align charts */
        justify-content: space-between; /* Space between charts */
    }

    .chart-container {
        margin-bottom: 30px;
        width: 48%; /* Adjust width to fit two charts side by side */
        border: 1px solid #000; /* Add border */
        padding: 10px; /* Add padding */
        border-radius: 5px; /* Optional: rounded corners */
        background-color: white; /* Set background color to white */
    }

    .chart {
        width: 100% !important;
        height: 300px !important;  /* Ajusta la altura de las gráficas */
    }

    h4 {
        text-align: center;
        margin-bottom: 20px;
        color: black; /* Set title color to black */
    }
</style>