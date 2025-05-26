<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $todayOrdersCount = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)
        ->where('order_type', '!=', 'dine_in') // استثناء طلبات QR
        ->with('orderItems')
        ->get()
        ->flatMap->orderItems
        ->sum(fn($item) => $item->quantity * $item->price);


        $activeMenuItemsCount = MenuItem::where('is_active', 1)->count();
        $todayReservations = Reservation::whereDate('created_at', $today)->count();

        // بيانات الرسم البياني (آخر 7 أيام)
        $ordersChartLabels = [];
        $ordersChartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $ordersChartLabels[] = $date->format('D');
            $ordersChartData[] = Order::whereDate('created_at', $date)->count();
        }

        // أعلى الأصناف مبيعًا
        $topSellingDishes = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('menu_items.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'todayOrdersCount',
            'todayRevenue',
            'activeMenuItemsCount',
            'todayReservations',
            'ordersChartLabels',
            'ordersChartData',
            'topSellingDishes'
        ));
    }
    public function stats()
{
    $totalOrders = \App\Models\Order::count();
    $todaysOrders = \App\Models\Order::whereDate('created_at', today())->count();
    $totalSales = \App\Models\OrderItem::sum(DB::raw('price * quantity'));    $todayReservations = Reservation::whereDate('created_at', today())->count();

    return view('admin.dashboard.partials.stats', compact('totalOrders', 'todaysOrders', 'totalSales', 'todayReservations' ));
}

public function topSelling()
{
    $topSellingDishes = \App\Models\OrderItem::select('menu_item_id', \DB::raw('SUM(quantity) as total_sold'))
        ->groupBy('menu_item_id')
        ->with('menuItem')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get()
        ->map(function ($item) {
            return (object)[
                'name' => optional($item->menuItem)->name ?? 'Unknown',
                'total_sold' => $item->total_sold,
            ];
        });

    return view('admin.dashboard.partials.top-selling', compact('topSellingDishes'));
}

public function chartData()
{
    $orders = \App\Models\Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->whereDate('created_at', '>=', now()->subDays(6)->toDateString())
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $labels = [];
    $data = [];

    $range = collect(range(0, 6))->map(function ($i) {
        return now()->subDays(6 - $i)->format('Y-m-d');
    });

    foreach ($range as $date) {
        $labels[] = \Carbon\Carbon::parse($date)->format('M d');
        $dayData = $orders->firstWhere('date', $date);
        $data[] = $dayData ? $dayData->total : 0;
    }

    return response()->json([
        'labels' => $labels,
        'data' => $data,
    ]);
}


}
