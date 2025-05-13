<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class MyOrderController extends Controller
{
    public function index(Request $request)
    {
        $email = session('customer_email');

        if (!$email) {
            return redirect('/login')->with('error', 'Please verify your email first.');
        }

        $user = User::where('email', $email)->first();

        $query = Order::with('orderItems.menuItem')
                      ->where('customer_email', $email);

        // ✅ إضافة الفلترة حسب نوع الطلب إن وجد
        if ($request->filled('type') && in_array($request->type, ['pickup', 'delivery'])) {
            $query->where('order_type', $request->type);
        }

        $orders = $query->latest()->get();

        return view('my_orders', compact('orders', 'user'));
    }
}
