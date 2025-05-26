<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class MyOrderController extends Controller
{
public function index(Request $request)
{
    if (!session()->has('customer_email')) {
        return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً.');
    }

    $email = session('customer_email');

    $query = Order::with('orderItems.menuItem')
                  ->where('customer_email', $email);

    if ($request->filled('type') && in_array($request->type, ['pickup', 'delivery'])) {
        $query->where('order_type', $request->type);
    }

    $orders = $query->latest()->get();

    return view('my_orders', [
        'orders' => $orders,
        'user' => User::where('email', $email)->first()
    ]);
}


}
