<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;


class QrCheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        try {
            $cart = session('qr_cart', []);
            if (empty($cart)) {
                return response()->json(['status' => 'error', 'message' => 'Cart is empty']);
            }

            $table = Table::where('table_number', $request->table_number)->first();
            if (!$table) {
                return response()->json(['status' => 'error', 'message' => 'Invalid table number']);
            }

            $conflict = Order::where('table_number', $request->table_number)
                ->whereIn('status', ['pending', 'preparing'])
                ->exists();

            // حساب الضريبة
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$taxRate = Setting::first()->order_tax_rate ?? 0;
$taxAmount = round($subtotal * ($taxRate / 100), 2);
$totalWithTax = round($subtotal + $taxAmount, 2);

// إنشاء الطلب
$order = Order::create([
    'customer_name'   => $request->customer_name,
    'customer_phone'  => $request->customer_phone,
    'order_type'      => 'dine_in',
    'table_number'    => $request->table_number,
    'payment_method'  => $request->payment_method,
    'status'          => 'pending',
    'token'           => Str::uuid()->toString(),
    'table_conflict'  => $conflict,
    'tax_rate'        => $taxRate,
    'tax_amount'      => $taxAmount,
    'total'           => $totalWithTax,
]);


            foreach ($cart as $id => $item) {
                $menuItemId = is_numeric($id) ? $id : explode('-', $id)[0];

                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => (int) $menuItemId,
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                    'options'      => isset($item['options']) ? json_encode($item['options']) : null,
                ]);
            }

            session()->forget('qr_cart');

            return response()->json(['status' => 'success', 'token' => $order->token]);
        } catch (\Exception $e) {
            Log::error("QR Checkout Error: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }

public function calculateTax()
{
    $cart = session('qr_cart', []);
    $subtotal = 0;

    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    $taxRate = \App\Models\Setting::first()?->order_tax_rate ?? 0;
    $taxAmount = $subtotal * ($taxRate / 100);
    $totalWithTax = $subtotal + $taxAmount;

    return response()->json([
        'subtotal' => number_format($subtotal, 2, '.', ''),
        'tax_rate' => $taxRate,
        'tax_amount' => number_format($taxAmount, 2, '.', ''),
        'total' => number_format($totalWithTax, 2, '.', ''),
    ]);
}

}
