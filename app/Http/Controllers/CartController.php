<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
{
    // ✅ إذا فيه order_sent = لازم نفضي السلة ونعمل Redirect
    if (session()->has('order_sent')) {
        session()->forget('cart');
        session()->forget('order_sent');
        return redirect()->route('cart.index', ['cleared' => 1]); // ✅ مهم جدًا
    }

    // ✅ إذا رجع من cleared، ما ترجع redirect مرة ثانية
    if (request()->has('cleared')) {
        return view('cart.index', ['cart' => []]); // سلة فاضية بعد المسح
    }

    $cart = session()->get('cart', []);
    return view('cart.index', compact('cart'));
}


    public function add(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'nullable|integer|min:0',
            'options' => 'array',
            'options.*.id' => 'required|exists:option_values,id',
            'options.*.price' => 'required|numeric|min:0',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);
        $options = $request->input('options', []);
        $optionsPrice = collect($options)->sum('price');
        $finalPrice = $menuItem->price + $optionsPrice;

        $cart[$menuItem->id] = [
            'name' => $menuItem->name,
            'price' => $finalPrice,
            'quantity' => $quantity,
            'image' => $menuItem->image,
            'options' => $options,
        ];

        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $count = collect($cart)->sum('quantity');
            return response()->json([
                'status' => 'ok',
                'total' => $total,
                'count' => $count
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function addAjax(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'final_price' => 'required|numeric|min:0',
            'options' => 'nullable|array',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);
        $cart = session()->get('cart', []);

        $uniqueId = $menuItem->id;

        // إذا فيه خيارات، نميّز العنصر بترميز فريد
        if (!empty($request->options)) {
            $optionsKey = md5(json_encode($request->options));
            $uniqueId = $menuItem->id . '-' . $optionsKey;
        }

        $cart[$uniqueId] = [
            'menu_item_id' => $menuItem->id,
            'name' => $menuItem->name,
            'price' => $request->final_price, // السعر بعد الإضافات
            'quantity' => ($cart[$uniqueId]['quantity'] ?? 0) + $request->quantity,
            'image' => $menuItem->image,
            'options' => $request->options ?? [],
        ];

        session()->put('cart', $cart);

        // Response للعداد والتوتال
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $count = collect($cart)->sum('quantity');

        return response()->json([
            'count' => $count,
            'total' => $total,
        ]);
    }


    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->menu_item_id])) {
            unset($cart[$request->menu_item_id]);
            session()->put('cart', $cart);
        }

        if ($request->expectsJson()) {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            return response()->json([
                'status' => 'ok', 
                'total' => $total, 
                'count' => collect($cart)->sum('quantity'),
                'message' => 'Item removed successfully'
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {

        $request->validate([
            'order_type' => 'required|in:pickup,delivery,dine_in',
            'name' => 'required|string|max:255',
            'full_phone' => 'required|string|max:20',
            'pickup_time' => $request->order_type === 'pickup' ? 'required|string' : 'nullable',
            'delivery_time' => $request->order_type === 'delivery' ? 'required|string' : 'nullable',
            'payment_method' => 'required|in:cash,visa',
            'address' => $request->order_type === 'delivery' ? 'required|string' : 'nullable',
            'notes' => 'nullable|string',
            'pickup_receiver' => 'nullable|string',
        ]);
        $now = now();

if ($request->order_type === 'pickup' && $request->filled('pickup_time')) {
    $pickupTime = now()->format('Y-m-d') . ' ' . $request->pickup_time;
    if (strtotime($pickupTime) < strtotime($now)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Pickup time cannot be earlier than the current time.'
        ], 422);
    }
}

if ($request->order_type === 'delivery' && $request->filled('delivery_time')) {
    $deliveryTime = now()->format('Y-m-d') . ' ' . $request->delivery_time;
    if (strtotime($deliveryTime) < strtotime($now)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Delivery time cannot be earlier than the current time.'
        ], 422);
    }
}

        if ($request->order_type === 'dine_in') {
            $tableNumber = \App\Models\Table::where('qr_token', session('qr_token'))->value('table_number');

            if (!$tableNumber) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Table not recognized. Please rescan the QR.'
                ], 422);
            }

            $existingOrder = Order::where('table_number', $tableNumber)
                ->where('order_type', 'dine_in')
                ->where('status', '!=', 'completed')
                ->first();

            if ($existingOrder) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'An order from this table is already in progress. Please wait until it is completed.'
                ], 409);
            }
        }

        DB::beginTransaction();

        try {
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return redirect()->back()->withErrors(['cart' => 'Your cart is empty.']);
            }

            $order = new Order();
            if ($request->order_type === 'dine_in') {
                $order->table_number = \App\Models\Table::where('qr_token', session('qr_token'))->value('table_number');
            }
            $order->order_type = $request->order_type;
            $order->customer_name = $request->name;
            $order->customer_phone = $request->full_phone;
            session(['customer_phone' => $request->full_phone]);
            $order->pickup_receiver = $request->pickup_receiver;
            $order->payment_method = $request->payment_method;
            $order->status = 'pending';
            $order->notes = $request->notes;
            $order->customer_email = $request->order_type !== 'dine_in' ? $request->customer_email : null;

            if ($request->order_type === 'pickup') {
                $order->pickup_time = now()->format('Y-m-d') . ' ' . $request->pickup_time;
                if ($request->filled('pickup_receiver')) {
                    $order->notes = 'Receiver: ' . $request->pickup_receiver . "\n" . ($request->notes ?? '');
                }
            } elseif ($request->order_type === 'delivery') {
                $order->customer_address = $request->address;
                $order->pickup_time = now()->format('Y-m-d') . ' ' . $request->delivery_time;
            }

            $order->save();

foreach ($cart as $id => $item) {
    $menuItemId = isset($item['menu_item_id']) ? $item['menu_item_id'] : (int) explode('-', $id)[0];

    OrderItem::create([
        'order_id'     => $order->id,
        'menu_item_id' => $menuItemId,
        'quantity'     => $item['quantity'],
        'price'        => $item['price'],
        'options'      => isset($item['options']) ? json_encode($item['options']) : null,
    ]);
}

// ✅ ضيف هذا السطر هون
session()->forget('cart'); // حذف السلة
session()->put('order_sent', true); // تفعيل الفلاج عشان يتم redirect مرة وحدة بس

return response()->json([
    'status' => 'ok',
    'message' => 'Order placed successfully',
    'order_id' => $order->id
]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to place order: ' . $e->getMessage()
            ]);
        }
    }

    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'status' => 'ok',
            'message' => 'Cart cleared successfully',
            'count' => 0,
            'total' => 0
        ]);
    }

    public function clearAndShow()
    {
        session()->forget('cart');
        return redirect()->route('cart.index', ['cleared' => 1]);
    }

    public function addFromQR(Request $request)
{
    $request->validate([
        'item_id' => 'required|exists:menu_items,id',
        'quantity' => 'nullable|integer|min:1',
        'final_price' => 'required|numeric|min:0',
        'options' => 'nullable|array',
    ]);

    $item = MenuItem::findOrFail($request->item_id);
    $cart = session()->get('qr_cart', []);

    $quantity = $request->input('quantity', 1);
    $options = $request->input('options', []);

    $uniqueId = $item->id;

    if (!empty($options)) {
        $optionsKey = md5(json_encode($options));
        $uniqueId = $item->id . '-' . $optionsKey;
    }

    $cart[$uniqueId] = [
        'menu_item_id' => $item->id,
        'name'         => $item->name,
        'price'        => $request->final_price,
        'quantity'     => ($cart[$uniqueId]['quantity'] ?? 0) + $quantity,
        'image'        => $item->image,
        'options'      => $options,
    ];

    session()->put('qr_cart', $cart);

    return response()->json([
        'message' => 'Item added to cart',
        'count' => collect($cart)->sum('quantity'),
    ]);
}

}