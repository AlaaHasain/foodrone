<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\{Gallery, MenuItem, Table, Order, OrderItem};
use App\Http\Controllers\OfferController;
use Illuminate\Support\Str;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\TableQrController;
use App\Http\Controllers\FrontendReservationController;
use App\Http\Controllers\ContactReplyController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\QrCheckoutController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterInfoController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactMessageController;



// -----------------------------
// \ud83c\udfe1 الموقع العادي (Frontend)
// -----------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu');
Route::get('/menu/{id}', [App\Http\Controllers\MenuController::class, 'show'])->name('menu.show');

Route::get('/search/ajax', [SearchController::class, 'ajaxSearch']);


// \ud83d\uded2 السلة (Cart)
// -----------------------------
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/ajax-add', [CartController::class, 'addAjax'])->name('add-ajax');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clearAndShow'])->name('clear');
    Route::post('/clear-json', [CartController::class, 'clear'])->name('clear.json');
});
Route::get('/cart/checkout', [CartController::class, 'checkout'])
    ->middleware('check.customer')
    ->name('cart.checkout');

Route::post('/cart/place-order', [\App\Http\Controllers\Admin\OrderController::class, 'store'])->name('cart.placeOrder');

Route::get('/offers', fn () => view('offers', ['offers' => MenuItem::where('is_offer', 1)->get()]))->name('offers');
Route::get('/offers/options/{id}', [OfferController::class, 'getOptions']);

Route::get('/logout', function () {
    session()->flush();
    return redirect()->route('home')->with('success', 'You have been logged out.');
})->name('logout');

Route::get('/reservation', fn () => view('reservation'))->name('reservation');
Route::get('/testimonials', fn () => view('testimonials'))->name('testimonials');
Route::get('/gallery', fn () => view('gallery', ['galleries' => Gallery::latest()->get()]))->name('gallery');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// -----------------------------

// -----------------------------
// \ud83d\udcc5 الحجوزات - الشهادات - التواصل
// -----------------------------
Route::post('/reservation', [FrontendReservationController::class, 'store'])
    ->middleware('check.customer')
    ->name('reservation.store');

Route::post('/testimonials', [App\Http\Controllers\TestimonialController::class, 'store'])
    ->middleware('check.customer')
    ->name('testimonials.store');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/contact/reply/{id}', [ContactReplyController::class, 'showReplyForm'])->name('contact.reply.form');
Route::post('/contact/reply/{id}', [ContactReplyController::class, 'submitReply'])->name('contact.reply.submit');
Route::get('/contact/reply/{id}/fetch-new', [ContactReplyController::class, 'fetchNewReplies'])->name('contact.reply.fetch-new');

// -----------------------------
// \ud83d\udcf2 تسجيل الدخول و OTP
// -----------------------------
Route::get('/login', [LoginController::class, 'showPhoneForm'])->name('login');
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('send.otp');
Route::get('/verify-otp', [LoginController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/resend-otp', [App\Http\Controllers\LoginController::class, 'resendOtp'])->name('resend.otp');

// -----------------------------
// \ud83d\udcc6 الطلبات الخاصة بي
// -----------------------------
Route::get('/my-orders', [MyOrderController::class, 'index'])
    ->middleware('check.customer')
    ->name('my_orders');

Route::get('/check-order-status', [MyOrderController::class, 'checkStatus'])->name('orders.checkStatus');

// -----------------------------
// \ud83c\udf7d\ufe0f QR Menu & Cart
// -----------------------------

Route::get('/qr/item/{id}', function ($id) {
    return MenuItem::with('options.values')->findOrFail($id);
});
Route::get('/qr/cart', function () {


    $token = request('token');

    if (!$token || !Table::where('qr_token', $token)->exists()) {
        abort(404);
    }

    return view('qr.cart', ['token' => $token]);
})->name('qr.cart');
Route::post('/qr/cart/add', [CartController::class, 'addFromQR'])->name('qr.cart.add');
Route::post('/qr/cart/remove', function (Request $request) {
    $cart = session('qr_cart', []);
    unset($cart[$request->item_id]);
    session(['qr_cart' => $cart]);
    return response()->json([
        'count' => collect($cart)->sum('quantity'),
        'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity'])
    ]);
})->name('qr.cart.remove');
Route::post('/qr/cart/update', function (Request $request) {
    $cart = session('qr_cart', []);
    $id = $request->item_id;
    $quantity = (int) $request->quantity;
    if (isset($cart[$id]) && $quantity > 0) {
        $cart[$id]['quantity'] = $quantity;
    } elseif (isset($cart[$id])) {
        unset($cart[$id]);
    }
    session(['qr_cart' => $cart]);
    return response()->json([
        'count' => collect($cart)->sum('quantity'),
        'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
        'subtotal' => isset($cart[$id]) ? $cart[$id]['price'] * $cart[$id]['quantity'] : 0,
    ]);
})->name('qr.cart.update');
Route::post('/qr/cart/checkout', [QrCheckoutController::class, 'checkout'])->name('qr.cart.checkout');


Route::get('/qr/order/{token}', fn($token) => view('qr.order-details', ['order' => Order::where('token', $token)->with('orderItems.menuItem')->firstOrFail()]))->name('qr.order.details');
Route::post('/qr/cart/clear', fn() => session()->forget('qr_cart') && response()->json(['status' => 'cleared']))->name('qr.cart.clear');
Route::get('/qr/{token}', [TableQrController::class, 'showMenu'])->name('menu.qr.view');
Route::get('/qr/tax/calculate', [\App\Http\Controllers\QrCheckoutController::class, 'calculateTax'])->name('qr.tax.calculate');

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

    Session::put('locale', $locale); // ✅ استخدم Session::put بدل session([...])
    return redirect()->back(); // أو ممكن تخليها redirect('/')
})->name('set.language');

// 🛡️ صفحة تسجيل الدخول للإدارة
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
});
Route::get('/admin/logout', function () {
    session()->forget(['admin_id', 'admin_name', 'admin_role']);
    session()->flush(); // اختيارية، لمسح الجلسة بالكامل
    return redirect()->route('admin.login')->with('success', 'Logged out successfully');
})->name('admin.logout');

Route::get('/admin/testimonials/pending-count', [\App\Http\Controllers\Admin\TestimonialController::class, 'pendingCount'])->name('admin.testimonials.pendingCount');

Route::get('/admin/reservations/pending-count', [\App\Http\Controllers\Admin\ReservationController::class, 'pendingCount'])->name('admin.reservations.pendingCount');

Route::get('/admin/orders/pending-count', [\App\Http\Controllers\Admin\OrderController::class, 'pendingCount'])->name('admin.orders.pendingCount');

// -----------------------------
// \ud83d\udea7 لوحة التحكم (Admin)
// -----------------------------
Route::prefix('admin')->name('admin.')->middleware('check.admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats'); // AJAX

    Route::get('/orders/fetch', [OrderController::class, 'fetch'])->name('orders.fetch');    
    Route::resource('orders', OrderController::class);
    Route::get('/orders/pending-count', fn() => response()->json([
        'count' => Order::where('status', 'pending')->count()
    ]))->name('orders.pendingCount');
    Route::post('/orders/{order}/send-pdf', [OrderController::class, 'sendPdf'])->name('orders.sendPdf');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');

    Route::resource('galleries', GalleryController::class)->names('galleries');

    Route::resource('menu-items', MenuItemController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('tables', App\Http\Controllers\Admin\TableController::class);
    Route::get('/tables/{id}/qr', [App\Http\Controllers\Admin\TableController::class, 'qr'])->name('tables.qr');

    Route::resource('options', \App\Http\Controllers\Admin\OptionController::class);
    Route::get('option-values/{option}', [\App\Http\Controllers\Admin\OptionValueController::class, 'index'])->name('option-values.index');
    Route::get('option-values/{option}/create', [\App\Http\Controllers\Admin\OptionValueController::class, 'create'])->name('option-values.create');
    Route::post('option-values/{option}', [\App\Http\Controllers\Admin\OptionValueController::class, 'store'])->name('option-values.store');
    Route::get('option-values/{option}/edit/{optionValue}', [\App\Http\Controllers\Admin\OptionValueController::class, 'edit'])->name('option-values.edit');
    Route::put('option-values/{option}/{optionValue}', [\App\Http\Controllers\Admin\OptionValueController::class, 'update'])->name('option-values.update');
    Route::delete('option-values/{option}/{optionValue}', [\App\Http\Controllers\Admin\OptionValueController::class, 'destroy'])->name('option-values.destroy');

    Route::resource('reservations', ReservationController::class)->only(['index', 'destroy']);
    Route::post('reservations/{reservation}/accept', [ReservationController::class, 'accept'])->name('reservations.accept');

    Route::get('/contact-messages/unread-count', function () {
            $count = \App\Models\ContactMessage::where('is_read', false)->count();
            return response()->json(['count' => $count]);
        })->name('contact-messages.unread-count');
    Route::get('/contact-messages/fetch', [ContactMessageController::class, 'fetch'])->name('contact-messages.fetch');
    Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::post('contact-messages/{message}/reply', [ContactMessageController::class, 'reply'])->name('contact-messages.reply');
    Route::get('contact-messages/{id}/check-replies', [ContactMessageController::class, 'checkReplies']);
    
    Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::delete('testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    Route::get('/testimonials/pending-count', fn () => response()->json([
        'count' => \App\Models\Testimonial::where('is_approved', false)->count()
    ]))->name('testimonials.pendingCount');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/dashboard/top-selling', [DashboardController::class, 'topSelling'])->name('dashboard.topSelling');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chartData');

    Route::resource('footer-info', FooterInfoController::class)->only(['index', 'update']);
    Route::resource('users', UserController::class);
});

// \u274c صفحة 404 في حال فشل أي route
Route::fallback(fn () => response()->view('errors.404', [], 404));