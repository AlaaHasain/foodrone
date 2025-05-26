<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\Table;

class OrderController extends Controller
{
    public function index()
    {
        if (session()->has('order_sent')) {
        session()->forget('cart');
        session()->forget('order_sent');
        }
        
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    
public function show(Order $order)
{
    $order->load('orderItems.menuItem');

    $subtotal = $order->orderItems->sum(fn($item) => $item->price * $item->quantity);
    $taxRate = setting('order_tax_rate') ?? 0;
    $taxAmount = $subtotal * ($taxRate / 100);
    $totalWithTax = $subtotal + $taxAmount;

    return view('admin.orders.show', compact('order', 'subtotal', 'taxRate', 'taxAmount', 'totalWithTax'));
}


public function store(Request $request)
{
    try {
        Log::info('Received data:', $request->all());
        DB::beginTransaction();

        $data = $request->json()->all();
        Log::info('Parsed JSON:', $data);

        $order = new Order();
        $order->order_type       = $data['order_type'] ?? $request->order_type;
        $order->customer_name    = $data['name'] ?? $request->name;
        $order->customer_phone   = $data['full_phone'] ?? $request->full_phone;
        $order->pickup_receiver  = $data['pickup_receiver'] ?? $request->pickup_receiver;
        $order->payment_method   = $data['payment_method'] ?? $request->payment_method;
        $order->status           = 'pending';
        $order->notes            = $data['notes'] ?? $request->notes ?? null;
        $order->customer_email   = $data['customer_email'] ?? $request->customer_email ?? session('customer_email');
        $order->table_number     = $data['table_number'] ?? $request->table_number;

        if (isset($data['pickup_time']) || $request->has('pickup_time')) {
            $pickupTime = $data['pickup_time'] ?? $request->pickup_time;
            $formattedTime = now()->format('Y-m-d') . ' ' . $pickupTime;
            $order->pickup_time = $formattedTime;
        }

        if (($data['order_type'] ?? $request->order_type) === 'delivery') {
            $order->customer_address = $data['address'] ?? $request->address;
        }

        $order->save();

        // ✅ معالجة بيانات السلة
        $cartData = $data['cart'] ?? $request->cart;
        if (is_string($cartData)) {
            $cartData = json_decode($cartData, true);
        }

        if (empty($cartData)) {
            throw new \Exception('Cart data is missing or empty');
        }

        Log::info('Cart Data:', ['cart' => $cartData]);

        foreach ($cartData as $item) {
            // تحسين معالجة menu_item_id
            $menuItemId = null;
            
            // طريقة 1: إذا كان menu_item_id قيمة صحيحة، استخدمها
            if (isset($item['menu_item_id'])) {
                if (is_numeric($item['menu_item_id'])) {
                    $menuItemId = intval($item['menu_item_id']);
                } elseif (is_string($item['menu_item_id']) && strpos($item['menu_item_id'], '-') !== false) {
                    // طريقة 2: إذا كان سلسلة نصية مثل "7-d3cdb6337642bbfbe2b61f99e88a554"
                    $parts = explode('-', $item['menu_item_id']);
                    $menuItemId = intval($parts[0]);
                }
            }

            if (!$menuItemId) {
                throw new \Exception('Invalid or missing menu_item_id for one of the cart items.');
            }

            // ✅ تجهيز الخيارات إذا موجودة
            $options = isset($item['options']) && is_array($item['options']) ? json_encode($item['options']) : null;

            // تسجيل كل عنصر في log
            Log::info('Processing item:', [
                'menu_item_id' => $menuItemId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'options' => $options
            ]);

            OrderItem::create([
                'order_id'     => $order->id,
                'menu_item_id' => $menuItemId,
                'quantity'     => $item['quantity'],
                'price'        => $item['price'],
                'options'      => $options,
            ]);
        }

        DB::commit();
        return response()->json(['status' => 'ok']);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order Store Error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'nullable|in:pending,preparing,ready,completed',
            'table_number' => 'nullable|string|exists:tables,table_number',
        ]);

        if ($request->has('only_status') && $request->status !== $order->status) {
            $order->status = $request->status;
            $order->status_updated_at = now();
            if ($request->status === 'completed') {
                $order->table_conflict = false;
            }
            $order->save();
            return response()->json(['success' => true]);
        }

        if ($request->has('only_table')) {
            $order->table_number = $request->table_number;
            $conflict = false;
            if ($order->status !== 'completed') {
                $relatedOrders = Order::where('id', '!=', $order->id)
                    ->where('table_number', $request->table_number)
                    ->get();

                $conflict = $relatedOrders->contains(fn($o) => $o->status !== 'completed');
            }
            $order->table_conflict = $conflict;
            $order->save();
            return back()->with('success', 'Table number updated successfully.');
        }

        if ($request->has('status')) {
            $order->status = $request->status;
            $order->status_updated_at = now();

            if ($order->status === 'completed') {
                $order->table_conflict = false;
            } else {
                $checkTable = $request->table_number ?? $order->table_number;
                $relatedOrders = Order::where('id', '!=', $order->id)
                    ->where('table_number', $checkTable)
                    ->get();

                $conflict = $relatedOrders->contains(fn($o) => $o->status !== 'completed');
                $order->table_conflict = $conflict;
            }
        }

        if ($request->has('table_number')) {
            $order->table_number = $request->table_number;
            if (($request->status ?? $order->status) !== 'completed') {
                $relatedOrders = Order::where('id', '!=', $order->id)
                    ->where('table_number', $request->table_number)
                    ->get();
                $conflict = $relatedOrders->contains(fn($o) => $o->status !== 'completed');
                $order->table_conflict = $conflict;
            } else {
                $order->table_conflict = false;
            }
        }

        $order->save();
        return back()->with('success', 'Order updated.');
    }

    public function fetch(Request $request)
    {
        $orders = Order::with('orderItems.menuItem')
            ->orderByDesc('created_at')
            ->paginate(10);

        foreach ($orders as $order) {
            if ($order->order_type === 'dine_in') {
                $relatedOrders = Order::where('table_number', $order->table_number)
                    ->where('id', '!=', $order->id)
                    ->get();
                $order->table_conflict = $relatedOrders->contains(fn($o) => $o->status !== 'completed');
            }
        }

        $html = view('admin.orders.partials.list', compact('orders'))->render();

        return response()->json([
            'html' => $html,
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
            ],
        ]);
    }

    public function sendPdf(Order $order)
    {
        $order->load('orderItems.menuItem');

        if (empty($order->customer_email)) {
            return redirect()->back()->with('pdf_error', 'Customer email not found for this order.');
        }

        try {
            $pdf = PDF::loadView('admin.orders.pdf', compact('order'));
            $fileName = 'order_' . $order->id . '.pdf';

            Mail::send([], [], function ($message) use ($order, $pdf, $fileName) {
                $message->to($order->customer_email)
                        ->subject('Your Order Invoice #' . $order->id)
                        ->attachData($pdf->output(), $fileName);
            });

            return redirect()->back()->with('pdf_sent', 'PDF sent successfully to the customer.');
        } catch (\Exception $e) {
            return redirect()->back()->with('pdf_error', 'Failed to send PDF: ' . $e->getMessage());
        }
    }

    public function pendingCount()
{
    $count = \App\Models\Order::where('status', 'pending')->count();
    return response()->json(['count' => $count]);
}

}