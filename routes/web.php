<?php

use App\Models\Gallery;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\ContactReplyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterInfoController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\FrontendReservationController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\TestimonialController as FrontendTestimonialController;
use App\Http\Controllers\TableQrController;
use App\Http\Controllers\Admin\TableController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏡 صفحات الموقع العادي
Route::get('/', [HomeController::class, 'index'])->name('home');



Route::get('/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu');
// Route::get('/menu/{id}', [App\Http\Controllers\MenuController::class, 'show'])->name('menu.show');


// 🛒 سلة المشتريات Cart
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/ajax-add', [CartController::class, 'addAjax'])->name('cart.add-ajax');
Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/place-order', [App\Http\Controllers\CartController::class, 'placeOrder'])->name('cart.placeOrder');
Route::post('/cart/clear', [CartController::class, 'clearAndShow'])->name('cart.clear');

// web.php

Route::get('/offers', function () {
    $offers = MenuItem::where('is_offer', 1)->get();
    return view('offers', compact('offers'));
})->name('offers');

Route::get('/logout', function () {
    session()->forget('otp_email');
    session()->forget('welcome_shown');
    session()->flush();
    return redirect()->route('home')->with('success', 'You have been logged out.');
})->name('logout');

// Route::get('/menu', function () {
//     $menuItems = MenuItem::all();
//     return view('menu', compact('menuItems'));
// })->name('menu');

Route::get('/reservation', function () {
    return view('reservation');
})->name('reservation');

Route::get('/testimonials', function () {
    return view('testimonials');
})->name('testimonials');

Route::get('/gallery', function () {
    $galleries = Gallery::latest()->get();
    return view('gallery', compact('galleries'));
})->name('gallery');

Route::get('/qr/item/{id}', function ($id) {
    return \App\Models\MenuItem::findOrFail($id);
});
Route::post('/qr/cart/add', [CartController::class, 'addFromQR'])->name('qr.cart.add');
// QR Cart View
Route::get('/qr/cart', function () {
    $token = request()->query('token');  // ✅ هذا يسحب التوكن من الـ URL
    return view('qr.cart', compact('token')); // ✅ هذا يمرره للـ view
})->name('qr.cart');


// QR Cart Remove Item
Route::post('/qr/cart/remove', function (\Illuminate\Http\Request $request) {
    $cart = session()->get('qr_cart', []);
    unset($cart[$request->item_id]);
    session()->put('qr_cart', $cart);

    return response()->json([
        'count' => collect($cart)->sum('quantity'),
        'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
    ]);
})->name('qr.cart.remove');

// QR Cart Update Quantity
Route::post('/qr/cart/update', function (\Illuminate\Http\Request $request) {
    $cart = session()->get('qr_cart', []);
    $id = $request->item_id;
    $quantity = (int) $request->quantity;

    if (isset($cart[$id]) && $quantity > 0) {
        $cart[$id]['quantity'] = $quantity;
    } elseif (isset($cart[$id]) && $quantity <= 0) {
        unset($cart[$id]);
    }

    session()->put('qr_cart', $cart);

    return response()->json([
        'count' => collect($cart)->sum('quantity'),
        'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
        'subtotal' => isset($cart[$id]) ? $cart[$id]['price'] * $cart[$id]['quantity'] : 0,
    ]);
})->name('qr.cart.update');


Route::post('/qr/cart/checkout', function (Request $request) {
    $cart = session()->get('qr_cart', []);

    if (empty($cart)) {
        return response()->json(['status' => 'error', 'message' => 'Cart is empty']);
    }

    // ✅ جلب معلومات الطاولة من جدول tables بناءً على رقم الطاولة
    $table = Table::where('table_number', $request->table_number)->first();

    if (!$table) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid table number',
        ]);
    }

    // ✅ إنشاء الطلب وتخزين qr_token الخاص بالطاولة داخل الطلب
    $order = Order::create([
        'customer_name'   => $request->customer_name,
        'order_type'      => 'dine_in',
        'table_number'    => $request->table_number,
        'payment_method'  => $request->payment_method,
        'status'          => 'pending',
        'token'           => $table->qr_token, // ✅ هذا هو المفتاح لنجاح الربط
    ]);

    // ✅ إضافة العناصر إلى جدول order_items
    foreach ($cart as $id => $item) {
        OrderItem::create([
            'order_id'     => $order->id,
            'menu_item_id' => $id,
            'quantity'     => $item['quantity'],
            'price'        => $item['price'],
        ]);
    }

    // ✅ تفريغ السلة بعد الطلب
    session()->forget('qr_cart');

    // ✅ إعادة التوكن للواجهة لاستخدامه في redirection
    return response()->json([
        'status' => 'success',
        'token'  => $order->token,
    ]);
})->name('qr.cart.checkout');


Route::get('/qr/order/{token}', function ($token) {
    $order = \App\Models\Order::where('token', $token)->with('orderItems.menuItem')->firstOrFail();
    return view('qr.order-details', compact('order'));
})->name('qr.order.details');




Route::post('/qr/cart/clear', function () {
    session()->forget('qr_cart');
    return response()->json(['status' => 'cleared']);
})->name('qr.cart.clear');


Route::get('/login', [LoginController::class, 'showPhoneForm'])->name('login');
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('send.otp');
Route::get('/verify-otp', [LoginController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('verify.otp');

// الطلبات بعد التحقق
Route::get('/my-orders', [\App\Http\Controllers\MyOrderController::class, 'index'])->name('my_orders');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::post('/testimonials', [FrontendTestimonialController::class, 'store'])->name('testimonials.store');
Route::post('/reservation', [FrontendReservationController::class, 'store'])->name('reservation.store');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/check-order-status', [MyOrderController::class, 'checkStatus'])->name('orders.checkStatus');

Route::get('/contact/reply/{id}', [ContactReplyController::class, 'showReplyForm'])->name('contact.reply.form');
Route::post('/contact/reply/{id}', [ContactReplyController::class, 'submitReply'])->name('contact.reply.submit');
Route::get('/contact/reply/{id}/fetch-new', [ContactReplyController::class, 'fetchNewReplies'])->name('contact.reply.fetch-new');

Route::post('admin/contact-messages/{id}/reply', [App\Http\Controllers\Admin\ContactMessageController::class, 'reply'])->name('admin.contact-messages.{id}.reply');
Route::get('admin/contact-messages/{id}/check-replies', [App\Http\Controllers\Admin\ContactMessageController::class, 'checkReplies']);
Route::get('admin/contact-messages/unread-count', [App\Http\Controllers\Admin\ContactMessageController::class, 'unreadCount'])->name('admin.contact-messages.unread-count');

Route::get('/qr/{token}', [TableQrController::class, 'showMenu'])->name('menu.qr.view');

// ✨ لوحة التحكم - المسار الأساسي /admin
Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');  // هنا يتم تعريف مسار العرض
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::post('/orders/{order}/send-pdf', [App\Http\Controllers\Admin\OrderController::class, 'sendPdf'])->name('orders.sendPdf'); 
        Route::get('/orders/pending-count', function () {
            return response()->json([
                'count' => \App\Models\Order::where('status', 'pending')->count()
            ]);
        })->name('orders.pendingCount');

        Route::get('/contact-messages', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])
        ->name('contact-messages.index');
        Route::get('/contact-messages/{id}', [App\Http\Controllers\Admin\ContactMessageController::class, 'show'])
        ->name('contact-messages.show');
        Route::delete('/contact-messages/{contactMessage}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])
        ->name('contact-messages.destroy');
        Route::post('contact-messages/{message}/reply', [ContactMessageController::class, 'reply'])->name('contact-messages.reply');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('menu-items', MenuItemController::class);
        Route::resource('reservations', \App\Http\Controllers\Admin\ReservationController::class)->only(['index', 'destroy']);
        Route::post('reservations/{reservation}/accept', [App\Http\Controllers\Admin\ReservationController::class, 'accept'])->name('reservations.accept');
        Route::resource('galleries', GalleryController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
        Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
        Route::delete('testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
        Route::get('/testimonials/pending-count', function () {
            return response()->json([
                'count' => \App\Models\Testimonial::where('is_approved', false)->count()
            ]);
        })->name('testimonials.pendingCount');
    

        Route::resource('tables', App\Http\Controllers\Admin\TableController::class);
        Route::get('/tables/{id}/qr', [\App\Http\Controllers\Admin\TableController::class, 'qr'])->name('tables.qr');

        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        Route::resource('footer-info', FooterInfoController::class)->only(['index', 'update']);
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::post('settings/change-password', [SettingController::class, 'changePassword'])->name('settings.change-password');
        Route::resource('users', UserController::class);
    
    }); // إغلاق مجموعة admin


Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

