@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .stat-card h3 {
        font-size: 16px;
        color: #888;
        margin-bottom: 10px;
    }

    .stat-card p {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .flex-charts {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .chart-container, .top-selling {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .top-selling table {
        width: 100%;
        border-collapse: collapse;
    }

    .top-selling th, .top-selling td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    .top-selling th {
        background: #f7f7f7;
        font-weight: bold;
        color: #555;
    }

    .top-selling tr:last-child td {
        border-bottom: none;
    }
</style>

<div class="stats-container">
    <div class="stat-card">
        <h3>Today's Orders</h3>
        <p>{{ $todayOrdersCount }}</p>
    </div>
    <div class="stat-card">
        <h3>Revenue Today<br><small>(pick up , delivery)</small></h3>
        <p>${{ number_format($todayRevenue, 2) }}</p>
    </div>
    <div class="stat-card">
        <h3>Active Menu Items</h3>
        <p>{{ $activeMenuItemsCount }}</p>
    </div>
    <div class="stat-card">
        <h3>Reservations Today</h3>
        <p>{{ $todayReservations }}</p>
    </div>
</div>

<div class="flex-charts mt-5">
    {{-- الرسم البياني --}}
    <div class="chart-container">
        <h4 class="mb-4">Orders in Last 7 Days</h4>
        <canvas id="ordersChart" height="100"></canvas>
    </div>

    {{-- الأصناف الأعلى مبيعًا --}}
    <div class="top-selling">
        <h4 class="mb-4">Top Selling Dishes</h4>
        <table>
            <thead>
                <tr>
                    <th>Dish</th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topSellingDishes as $dish)
                <tr>
                    <td>{{ $dish->name }}</td>
                    <td>{{ $dish->total_sold }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($ordersChartLabels) !!},
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($ordersChartData) !!},
                borderColor: '#ffbe33',
                backgroundColor: 'rgba(255, 190, 51, 0.1)',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
