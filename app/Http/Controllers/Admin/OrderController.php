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



class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // تأكد من تحميل العناصر المرتبطة بالطلب
        $order->load('orderItems.menuItem');
        return view('admin.orders.show', compact('order'));
    }

    public function store(Request $request)
    {

        try {
            
            Log::info('Received data:', $request->all());

            // استخدام المعاملات لضمان إتمام جميع العمليات أو التراجع عنها
            DB::beginTransaction();
            
            // التحقق إذا كانت البيانات جاءت كـ JSON
            $data = $request->json()->all();
            Log::info('Parsed JSON:', $data);
                        
            $order = new Order();
            $order->order_type = $data['order_type'] ?? $request->order_type;
            $order->customer_name = $data['name'] ?? $request->name;
            $order->customer_phone = $data['full_phone'] ?? $request->full_phone;
            $order->pickup_receiver = $data['pickup_receiver'] ?? $request->pickup_receiver;
            $order->payment_method = $data['payment_method'] ?? $request->payment_method;
            $order->status = 'pending';
            $order->notes = $data['notes'] ?? $request->notes ?? null;
            
            // تحسين معالجة البريد الإلكتروني - نحاول الوصول إليه بعدة طرق
            $order->customer_email = $data['customer_email'] ?? $request->customer_email ?? session('customer_email');
            
            // سجل البريد الإلكتروني المستخدم
            Log::info('Using email:', ['email' => $order->customer_email]);

            // وقت الاستلام حسب نوع الطلب
            if (isset($data['pickup_time']) || $request->has('pickup_time')) {
                $pickupTime = $data['pickup_time'] ?? $request->pickup_time;
                $formattedTime = now()->format('Y-m-d') . ' ' . $pickupTime;
                $order->pickup_time = $formattedTime;
            }
            
            if (($data['order_type'] ?? $request->order_type) === 'delivery') {
                $order->customer_address = $data['address'] ?? $request->address;
            }

            $order->save();

            // معالجة البيانات حسب المصدر (JSON أو form data)
            $cartData = $data['cart'] ?? $request->cart;

            if (is_string($cartData)) {
                $cartData = json_decode($cartData, true);
            }

            // تأكد من وجود بيانات السلة
            if (empty($cartData)) {
                throw new \Exception('Cart data is missing or empty');
            }
            
            Log::info('Cart Data:', ['cart' => $cartData]);

            // حفظ كل عنصر في السلة
            foreach ($cartData as $id => $item) {
                Log::info('Processing item:', ['id' => $id, 'item' => $item]);
                
                // تعامل مع الهيكل المختلف للكارت
                $menuItemId = isset($item['menu_item_id']) ? $item['menu_item_id'] : $id;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItemId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
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
            'status' => 'required|in:pending,preparing,ready,completed',
        ]);
    
        if ($order->status !== $request->status) {
            $order->status = $request->status;
            $order->status_updated_at = now(); // ✅ نحدّث التاريخ
            $order->save();
        }
    
        return redirect()->back()->with('success', 'Order status updated successfully.');
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
}