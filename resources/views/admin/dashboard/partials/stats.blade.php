<style>
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .dashboard-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        padding: 20px;
        text-align: center;
        transition: 0.3s;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .dashboard-card h5 {
        color: #999;
        font-size: 14px;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .dashboard-card h2 {
        color: #333;
        font-size: 28px;
        font-weight: bold;
    }
</style>

<div class="dashboard-cards">
    <div class="dashboard-card">
        <h5>Total Orders</h5>
        <h2 id="order-count">{{ $totalOrders }}</h2>
    </div>

    <div class="dashboard-card">
        <h5>Today’s Orders</h5>
        <h2>{{ $todaysOrders }}</h2>
    </div>

    <div class="dashboard-card">
        <h5>Total Sales</h5>
        <h2>${{ number_format($totalSales, 2) }}</h2>
    </div>

    <div class="dashboard-card">
        <h5>Today’s Reservations</h5>
        <h2>{{ $todayReservations ?? 0 }}</h2>
    </div>
</div>
