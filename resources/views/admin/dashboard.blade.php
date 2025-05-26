@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>

/* لإخفاء Scrollbar العمودي لكن يضل التمرير شغال */
body::-webkit-scrollbar {
    display: none; /* Chrome, Edge, Safari */
}

body {
    -ms-overflow-style: none;  /* IE 10+ */
    scrollbar-width: none;     /* Firefox */
}

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

<audio id="notificationSound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>

<div class="stats-container" id="dashboard-stats">
    <div class="text-center">Loading stats...</div>
</div>

<div class="flex-charts mt-5">
    <div class="chart-container">
        <h4 class="mb-4">Orders in Last 7 Days</h4>
        <canvas id="ordersChart" height="100"></canvas>
    </div>

    <div class="top-selling" id="top-selling-container">
        <div class="text-center">Loading top selling...</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let ordersChart;

    document.addEventListener("DOMContentLoaded", function () {
        document.body.addEventListener('click', function () {
            const audio = document.getElementById('notificationSound');
            if (audio) {
                audio.play().then(() => {
                    audio.pause();
                    audio.currentTime = 0;
                }).catch(() => {});
            }
        }, { once: true });

        function fetchStats() {
            fetch("{{ route('admin.dashboard.stats') }}")
                .then(res => res.text())
                .then(html => {
                    document.getElementById('dashboard-stats').innerHTML = html;
                });
        }

        function fetchTopSelling() {
            fetch("{{ route('admin.dashboard.topSelling') }}")
                .then(res => res.text())
                .then(html => {
                    document.getElementById('top-selling-container').innerHTML = html;
                });
        }

        function loadChartData() {
            fetch("{{ route('admin.dashboard.chartData') }}")
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('ordersChart').getContext('2d');
                    if (ordersChart) {
                        ordersChart.data.labels = data.labels;
                        ordersChart.data.datasets[0].data = data.data;
                        ordersChart.update();
                    } else {
                        ordersChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Orders',
                                    data: data.data,
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
                    }
                });
        }

        fetchStats();
        fetchTopSelling();
        loadChartData();

        setInterval(fetchStats, 15000);
        setInterval(loadChartData, 20000);
    });
</script>
@endsection