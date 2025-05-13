<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {   
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Add product to cart (with quantity update)
    public function add(Request $request)
    {
        
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'nullable|integer|min:0',
        ]);
    
        $menuItem = MenuItem::findOrFail($request->menu_item_id);
        $cart = session()->get('cart', []);
    
        if ($request->has('quantity')) {
            $quantity = (int)$request->quantity;
            if ($quantity <= 0) {
                unset($cart[$menuItem->id]);
            } else {
                $cart[$menuItem->id] = [
                    'name' => $menuItem->name,
                    'price' => $menuItem->price,
                    'quantity' => $quantity,
                    'image' => $menuItem->image,
                ];
            }
        } else {
            $cart[$menuItem->id] = [
                'name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => ($cart[$menuItem->id]['quantity'] ?? 0) + 1,
                'image' => $menuItem->image,
            ];
        }
    
        session()->put('cart', $cart);
    
        if ($request->expectsJson()) {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $count = collect($cart)->sum('quantity'); // ✅ التعديل المهم هنا
            return response()->json([
                'status' => 'ok',
                'total' => $total,
                'count' => $count
            ]);
        }
    
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }
    

    // Add product to cart via AJAX
    public function addAjax(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);
        $cart = session()->get('cart', []);
        
        // Use provided quantity or default to 1
        $quantity = $request->quantity ?? 1;

        // Add to cart or increment quantity
        $cart[$menuItem->id] = [
            'name' => $menuItem->name,
            'price' => $menuItem->price,
            'quantity' => ($cart[$menuItem->id]['quantity'] ?? 0) + $quantity,
            'image' => $menuItem->image,
        ];

        session()->put('cart', $cart);
        
        // Calculate total and count for AJAX response
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $count = collect($cart)->sum('quantity'); // ✅ هذا يحسب مجموع الكميات الفعلية


        return response()->json([
            // 'message' => $menuItem->name . ' added to cart!', 
            'count' => $count,
            'total' => $total
        ]);
    }

    // Remove product from cart
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->menu_item_id])) {
            unset($cart[$request->menu_item_id]);
            session()->put('cart', $cart);
        }

        // If request is coming from AJAX, return JSON
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

    
    // Checkout page
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
        // التحقق من صحة البيانات
        $request->validate([
            'order_type' => 'required|in:pickup,delivery',
            'name' => 'required|string|max:255',
            'full_phone' => 'required|string|max:20',
            'pickup_time' => $request->order_type === 'pickup' ? 'required|string' : 'nullable',
            'delivery_time' => $request->order_type === 'delivery' ? 'required|string' : 'nullable',
            'payment_method' => 'required|in:cash,visa',
            'address' => $request->order_type === 'delivery' ? 'required|string' : 'nullable',
            'notes' => 'nullable|string',
            'pickup_receiver' => 'nullable|string',
        ]);
    
        DB::beginTransaction();
    
        try {
            $cart = session()->get('cart', []);  // استرجاع السلة من الـ session
    
            // التحقق من أن السلة تحتوي على عناصر
            if (empty($cart)) {
                return redirect()->back()->withErrors(['cart' => 'Your cart is empty.']);
            }
    
            // إنشاء الطلب
            $order = new Order();
            $order->order_type = $request->order_type;
            $order->customer_name = $request->name;
            $order->customer_phone = $request->full_phone;
            session(['customer_phone' => $request->full_phone]);
            $order->pickup_receiver = $request->pickup_receiver;
            $order->payment_method = $request->payment_method;
            $order->status = 'pending';
            $order->notes = $request->notes;
            // $order->user_id = auth()->check() ? auth()->id() : null;
            $order->customer_email = $request->customer_email;


    
            // تعيين المعلومات الخاصة بنوع الطلب (Pick Up أو Delivery)
            if ($request->order_type === 'pickup') {
                $formattedTime = now()->format('Y-m-d') . ' ' . $request->pickup_time;
                $order->pickup_time = $formattedTime;
                
                if ($request->filled('pickup_receiver')) {
                    $order->notes = 'Receiver: ' . $request->pickup_receiver . "\n" . ($request->notes ?? '');
                }
            } else {
                $order->customer_address = $request->address;
                $formattedTime = now()->format('Y-m-d') . ' ' . $request->delivery_time;
                $order->pickup_time = $formattedTime;
            }
    
            $order->save(); // حفظ الطلب في قاعدة البيانات
    
            // إضافة عناصر السلة إلى جدول order_items
            foreach ($cart as $id => $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->menu_item_id = $id;
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->save(); // حفظ العناصر في جدول order_items
            }
    
            DB::commit(); // تأكيد المعاملة
    
            // تفريغ السلة بعد إتمام الطلب
            session()->forget('cart');
            session()->put('show_my_order', true);
    
            // إعادة التوجيه بعد إتمام الطلب
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'ok', 
                    'message' => 'Order placed successfully',
                    'order_id' => $order->id
                ]);
            }
    
            return redirect()->route('cart.index')->with('success', 'Your order has been placed successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Failed to place order: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()->withErrors(['error' => 'Failed to place order: ' . $e->getMessage()]);
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
    
    // هنا نرجع بعد مسح السلة إلى نفس صفحة السلة لكن مع علامة cleared=1
    return redirect()->route('cart.index', ['cleared' => 1]);
}
public function addFromQR(Request $request)
{
    $request->validate([
        'item_id' => 'required|exists:menu_items,id',
    ]);

    $item = MenuItem::findOrFail($request->item_id);
    $cart = session()->get('qr_cart', []);

    if (isset($cart[$item->id])) {
        $cart[$item->id]['quantity'] += 1;
    } else {
        $cart[$item->id] = [
            'name' => $item->name,
            'price' => $item->price,
            'image' => $item->image,
            'quantity' => 1,
        ];
    }

session()->put('qr_cart', $cart);

    return response()->json([
        'message' => 'Item added to cart',
        'count' => count($cart),
    ]);
}

}
