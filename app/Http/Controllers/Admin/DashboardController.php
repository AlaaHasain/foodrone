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
}
