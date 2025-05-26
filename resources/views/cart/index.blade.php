@extends('layouts.app')


@section('title', 'Your Cart')

{{-- توحيد جميع أنماط CSS في مكان واحد --}}
<style>
    /* تنسيقات العربة والمنتجات */
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
            max-height: 100px;
            margin-top: normal;
            margin-bottom: normal;
            padding-top: normal;
            padding-bottom: normal;
        }

        to {
            opacity: 0;
            transform: scale(0.95);
            max-height: 0;
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
    }

    .cart-row-remove {
        animation: fadeOut 0.4s ease forwards;
        overflow: hidden !important;
    }

    #cart-total.animate {
        animation: pulseTotal 0.4s ease;
    }

    @keyframes pulseTotal {
        0% {
            transform: scale(1);
            color: #222;
        }

        50% {
            transform: scale(1.2);
            color: #ffbe33;
        }

        100% {
            transform: scale(1);
            color: #222;
        }
    }

    /* إخفاء زر الساعة في حقل الوقت */
input[type="time"]::-webkit-calendar-picker-indicator {
    display: none;
}


    /* تنسيقات الكمية والأزرار */
    .qty-controls button {
        width: 32px;
        height: 32px;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .qty-controls .qty-number {
        font-size: 18px;
        font-weight: 500;
        min-width: 30px;
    }

    /* تنسيقات الأزرار والتوجيه */
    .btn-continue:hover,
    .btn-checkout:hover {
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(255, 190, 51, 0.4);
        transition: all 0.3s ease;
    }

    .btn-continue,
    .btn-checkout {
        transition: all 0.3s ease;
    }

    /* تنسيقات الإشعارات */
    .toast-container {
        z-index: 1100;
    }

    /* تنسيقات صفحة الطلب */
    .order-type-btn {
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.85;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .custom-radio-group {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .radio-option {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        color: #333;
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        border: 2px solid transparent;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        font-size: 16px;
    }

    .radio-option i {
        font-size: 18px;
        color: #ffbe33;
    }

    .radio-option:hover {
        background-color: #f1f1f1;
    }

    input[type="radio"]:checked+.radio-option {
        background-color: #ffbe33;
        color: white;
        border-color: #ffbe33;
    }

    input[type="radio"]:checked+.radio-option i {
        color: white;
    }

    .btn.active {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        font-weight: bold;
    }

    .btn-warning.active {
        background-color: #f3a700;
        border-color: #f3a700;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .input-error {
    border: 2px solid #dc3545 !important;
    animation: shake 0.3s ease-in-out;
}

.input-error-message {
    color: #dc3545;
    font-size: 14px;
    margin-top: 5px;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
}
@media (max-width: 768px) {
    .cart_table table thead {
        display: none;
    }

    .cart_table table tbody tr {
        display: block;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px;
    }

    .cart_table table tbody tr td {
        display: flex;
        justify-content: space-between;
        padding: 8px 10px;
        border: none;
        border-bottom: 1px solid #f1f1f1;
    }

    .cart_table table tbody tr td:last-child {
        border-bottom: none;
    }

    .cart_table table tbody tr td::before {
        content: attr(data-label);
        font-weight: bold;
        flex-basis: 50%;
        color: #444;
    }

    .cart_table table tbody tr td img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        margin-right: 10px;
    }
}
@media (max-width: 768px) {
    td[data-label="Dish"] {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: flex-start;
    }

    td[data-label="Dish"] img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    td[data-label="Dish"] strong {
        font-size: 16px;
        font-weight: 600;
        color: #222;
    }

    td[data-label="Dish"] > div {
        display: flex;
        flex-direction: column;
    }
}

.dish-cell {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: flex-start;
    text-align: start;
}

.dish-image img {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.dish-details {
    display: flex;
    flex-direction: column;
}

.dish-name {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 4px;
    color: #222;
}

.dish-options {
    padding-left: 18px;
    margin: 0;
    font-size: 13px;
    color: #666;
}

.dish-options li {
    list-style: disc;
    margin-bottom: 2px;
}

@media (max-width: 768px) {
    .dish-cell {
        flex-direction: row !important;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;
    }

    .dish-image img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 8px;
    }

    .dish-details {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dish-name {
        font-size: 14px;
        font-weight: bold;
        line-height: 1.2;
    }

    .dish-options {
        font-size: 12px;
        padding-left: 14px;
        margin-top: 4px;
    }

    .dish-options li {
        margin-bottom: 2px;
        list-style: disc;
    }
}

/* ✅ تحسين عرض صنف العربة داخل الجوال */
@media (max-width: 768px) {
    .dish-cell {
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
    }

    .dish-image img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
    }

    .dish-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dish-name {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 3px;
    }

    .dish-options {
        font-size: 12px;
        color: #777;
        padding-left: 16px;
        margin: 0;
    }

    .dish-options li {
        margin-bottom: 2px;
        list-style: disc;
    }

    .qty-controls {
        flex-wrap: nowrap;
    }

    .qty-controls .btn {
        min-width: 28px;
        height: 32px;
        padding: 0;
        font-size: 14px;
    }

    .qty-number {
        min-width: 25px;
        text-align: center;
    }
}


</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.css" />
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"></script>

@section('content')
    {{-- Header --}}
    @include('layouts.partials.header')

    <section class="cart_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-4">
                <h2>{{ __('cart.your_cart') }}</h2>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="cart_table table-responsive">
                <table class="table text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('cart.dish') }}</th>
                            <th>{{ __('cart.price') }}</th>
                            <th>{{ __('cart.quantity') }}</th>
                            <th>{{ __('cart.subtotal') }}</th>
                            <th>{{ __('cart.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        @php $total = 0; @endphp
                        @forelse ($cart as $id => $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr data-id="{{ $id }}" data-options='@json($item["options"])'>
    <td data-label="{{ __('cart.dish') }}">
    <div class="dish-cell d-flex align-items-center gap-2">
        <div class="dish-details">
            <strong class="dish-name d-block">{{ $item['name'] }}</strong>

            {{-- ✅ عرض الخيارات --}}
            @if (!empty($item['options']) && is_array($item['options']))
                <ul class="dish-options mb-0 ps-3 small text-muted">
                    @foreach ($item['options'] as $option)
                        @php
                            $label = is_array($option) ? ($option['label'] ?? $option['value'] ?? '') : $option;
                            $price = is_array($option) ? floatval($option['price'] ?? $option['additional_price'] ?? 0) : 0;
                        @endphp
<li>{{ $label }}</li>
                        @endforeach
                </ul>
            @endif
        </div>
    </div>
</td>

    <td data-label="{{ __('cart.price') }}">
        ${{ number_format($item['price'], 2) }}
    </td>
    <td data-label="{{ __('cart.quantity') }}">
        <div class="qty-controls d-flex justify-content-center align-items-center">
            <button class="btn btn-sm btn-outline-dark qty-minus">−</button>
            <span class="mx-2 qty-number">{{ $item['quantity'] }}</span>
            <button class="btn btn-sm btn-outline-dark qty-plus">+</button>
        </div>
    </td>
    <td data-label="{{ __('cart.subtotal') }}" class="item-subtotal">
        ${{ number_format($item['price'] * $item['quantity'], 2) }}
    </td>
    <td data-label="{{ __('cart.action') }}">
        <button class="btn btn-sm btn-danger btn-remove">{{ __('cart.remove') }}</button>
    </td>
</tr>

                        @empty
                            <tr id="empty-cart-row">
                                <td colspan="5" class="py-4">
                                    <div class="text-center">
                                        <i class="fa fa-shopping-cart fa-3x mb-3 text-muted"></i>
                                        <h5>{{ __('cart.empty_cart') }}</h5>
                                        <p class="text-muted">{{ __('cart.empty_cart_message') }}</p>
                                        <a href="{{ route('menu') }}" class="btn btn-warning mt-3">{{ __('cart.browse_menu') }}</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                                                @php
                            $taxRate = setting('order_tax_rate') ?? 0;
                            $taxAmount = $total * ($taxRate / 100);
                            $totalWithTax = $total + $taxAmount;
                        @endphp 
                    </tbody>
                </table>
            </div>

            @if (!empty($cart))
                <div class="text-center mt-4" id="cart-totals-section">
                    <div class="totals-box mb-4">
                        <h5>
                            {{ __('cart.subtotal') }}:
                            <span id="subtotal-amount">${{ number_format($total, 2) }}</span>
                        </h5>
                        <h5>
                            {{ __('cart.tax') }} ({{ $taxRate }}%):
                            <span id="tax-amount">${{ number_format($taxAmount, 2) }}</span>
                        </h5>
                        <h4 style="font-weight: bold;">
                            {{ __('cart.total') }}:
                            <span id="cart-total">${{ number_format($totalWithTax, 2) }}</span>
                        </h4>
                    </div>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                        <a href="{{ route('menu') }}" class="btn btn-secondary btn-continue px-4 py-2">
                            ← {{ __('cart.continue_ordering') }}
                        </a>
                        <button type="button" class="btn btn-warning btn-checkout px-4 py-2"
                            onclick="showCheckoutForm()">{{ __('cart.proceed_to_checkout') }}</button>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Checkout Section - Initially Hidden -->
    @if (!empty($cart))
        <section id="checkout-section" class="checkout_section layout_padding" style="display: none;">
            <div class="container">
                <div class="heading_container heading_center mb-4">
                    <h2>{{ __('cart.checkout') }}</h2>
                </div>

                <div class="text-center mb-3">
                    <i class="fas fa-hand-pointer fa-lg text-warning"></i>
                    <span class="fw-bold" style="font-size: 17px; color: #444;">
                        {{ __('cart.please_select_type') }}
                    </span>
                </div>

                <div class="text-center mb-4">
                    <button id="pickupBtn" class="btn btn-outline-secondary me-2 order-type-btn"
                        onclick="selectOrderType('pickup')">{{ __('cart.pickup') }}</button>

                    <button id="deliveryBtn" class="btn btn-outline-secondary order-type-btn"
                        onclick="selectOrderType('delivery')">{{ __('cart.delivery') }}</button>
                </div>

                <form action="{{ route('cart.placeOrder') }}" method="POST" class="bg-white p-4 rounded shadow-lg"
    id="checkout-form" style="display:none; max-width: 600px; margin: auto;">
    <div id="closed-warning" class="alert alert-warning text-center fw-bold d-none" role="alert">
        نحن حالياً خارج أوقات الدوام. الرجاء المحاولة لاحقًا.<br>
        <small>We are currently outside working hours. Please try again later.</small>
    </div>
    
    @csrf

    <input type="hidden" name="order_type" id="order_type">

<div class="mb-3">
    <label class="form-label">{{ __('cart.full_name') }}</label>
    <input type="text"
           name="name"
           class="form-control"
           placeholder="e.g. John Doe"
           value="{{ session('customer_name') }}"
           @if(session()->has('customer_name')) readonly @else required @endif
           pattern="^[A-Za-z]{2,}\s[A-Za-z]{2,}.*$"
           title="Please enter at least first and last name">
</div>


    {{-- رقم الهاتف مع اختيار الدولة --}}
<div class="mb-3">
    <label class="form-label">{{ __('cart.phone_number') }}</label>
    <input type="tel"
           name="phone"
           id="phone-input"
           class="form-control"
           value="{{ session('customer_phone') }}"
           @if(session()->has('customer_phone')) readonly @else required @endif>
</div>
<input type="hidden" name="full_phone" id="full-phone">

    
 {{-- حقل البريد الإلكتروني --}}
<div class="mb-3">
    <label class="form-label">{{ __('cart.email') }}</label>

    <input type="email"
           name="customer_email"
           class="form-control"
           placeholder="e.g. yourname@example.com"
           value="{{ session('customer_email') }}"
           @if(session()->has('customer_email')) readonly @else required @endif
           pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
           title="Please enter a valid email address">
</div>

    {{-- اسم المستلم (لـ Pick Up) --}}
    <div class="mb-3" id="pickup-recipient-group" style="display: none;">
        <label class="form-label">{{ __('cart.receiver_name') }}</label>
        <input type="text" name="pickup_receiver" class="form-control"
               placeholder="Name of the person who will pick it up"
               pattern="^[A-Za-z]{2,}\s[A-Za-z]{2,}.*$"
               title="Please enter at least first and last name">
    </div>

    {{-- الموقع (للتوصيل فقط) --}}
    <div class="mb-3" id="address-group" style="display: none;">
        <label class="form-label">{{ __('cart.delivery_address') }}</label>
        <input type="text" name="address" class="form-control" placeholder="e.g. Amman, 7th Circle">
    </div>

    {{-- موعد الاستلام/التوصيل --}}
    <label class="form-label">{{ __('cart.preferred_time') }}</label>
    <input type="time" id="preferredTime" class="form-control" required>
    <div id="time-error" class="invalid-feedback d-none">
        {{ __('cart.invalid_time') }}
    </div>

    

    {{-- الملاحظات --}}
    <div class="mb-3">
        <label class="form-label">{{ __('cart.notes') }}</label>
        <textarea name="notes" class="form-control" placeholder="Any special instructions?"></textarea>
    </div>

    {{-- الدفع --}}
    <div class="mb-4">
        <label class="form-label d-block mb-2">{{ __('cart.payment_method') }}</label>
        <div class="custom-radio-group justify-content-start">
            <input type="radio" id="payment_cash" name="payment_method" value="cash" checked hidden>
            <label for="payment_cash" class="radio-option">
                <i class="fas fa-money-bill-wave me-2"></i> {{ __('cart.cash') }}
            </label>

            <input type="radio" id="payment_visa" name="payment_method" value="visa" hidden>
            <label for="payment_visa" class="radio-option">
                <i class="fas fa-credit-card me-2"></i> {{ __('cart.visa') }}
            </label>
        </div>
    </div>

    <div class="text-center">
        <button type="button" id="submitOrderBtn" class="btn btn-warning btn-lg px-5">
            {{ __('cart.confirm_order') }}
        </button>
    </div>
</form>

                <div class="text-center mt-5">
                    <p style="font-size: 18px; color: #666;">
                        {{ __('cart.thank_you') }} <strong><span style="color: #a4c762;">Lemon</span><span style="color: #ffbe33;">grass</span></strong>! 🌿<br>
                        {{ __('cart.thank_you_message') }}
                    </p>


                    <a href="{{ route('home') }}" class="btn mt-3 px-4 py-2"
                        style="
                            background-color: #222831;
                            color: white;
                            border-radius: 30px;
                            font-weight: 500;
                            transition: 0.3s ease;
                            text-decoration: none;
                        "
                        onmouseover="this.style.backgroundColor='#333d4d'"
                        onmouseout="this.style.backgroundColor='#222831'">
                        ← {{ __('cart.back_to_home') }}
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const messages = {
    remove_title: "{{ __('cart.remove_confirm_title') }}",
    remove_text: "{{ __('cart.remove_confirm_text') }}",
    remove_yes: "{{ __('cart.remove_confirm_yes') }}",
    removed_title: "{{ __('cart.remove_success_title') }}",
    removed_text: "{{ __('cart.remove_success_text') }}",
    remove_failed: "{{ __('cart.remove_failed_text') }}",
    cancel: "{{ __('cart.cancel') }}",
    ok: "{{ __('cart.ok') }}"
};
</script>
@push('scripts')
<script>
function updateTotalDisplay(subtotal) {
    // الحصول على معدل الضريبة من البيانات أو استخدام القيمة الافتراضية
    const taxRateElement = document.querySelector('[data-tax-rate]');
    let taxRate = 16; // القيمة الافتراضية
    
    if (taxRateElement) {
        taxRate = parseFloat(taxRateElement.dataset.taxRate) || 16;
    } else {
        // البحث عن معدل الضريبة في النص
        const taxText = document.querySelector('#tax-amount')?.parentElement?.textContent;
        if (taxText) {
            const match = taxText.match(/\((\d+(?:\.\d+)?)\%\)/);
            if (match) {
                taxRate = parseFloat(match[1]);
            }
        }
    }
    
    const taxAmount = subtotal * (taxRate / 100);
    const total = subtotal + taxAmount;

    // تحديث العناصر في الصفحة
    const subtotalEl = document.getElementById('subtotal-amount');
    const taxEl = document.getElementById('tax-amount');
    const totalEl = document.getElementById('cart-total');

    if (subtotalEl) subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
    if (taxEl) taxEl.textContent = `$${taxAmount.toFixed(2)}`;
    if (totalEl) {
        totalEl.textContent = `$${total.toFixed(2)}`;
        // إضافة تأثير بصري
        totalEl.classList.add('animate');
        setTimeout(() => totalEl.classList.remove('animate'), 400);
    }

    console.log('💰 Total updated correctly:', { 
        subtotal: subtotal.toFixed(2), 
        taxRate: `${taxRate}%`, 
        taxAmount: taxAmount.toFixed(2), 
        total: total.toFixed(2) 
    });
}
</script>
@endpush


    <script>

document.addEventListener('DOMContentLoaded', function () {
    const orderSent = sessionStorage.getItem('order_sent');

    if (orderSent) {
        sessionStorage.removeItem('cart');
        sessionStorage.removeItem('order_sent');

        fetch("/cart/clear", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        }).then(() => {
            window.location.href = "/cart?cleared=1";
        });

        return; // هذا هو الشرط الوحيد اللي بيعمل redirect
    }

    const cartRowCount = document.querySelectorAll('#cart-body tr[data-id]').length;
    if (cartRowCount === 0) {
        sessionStorage.removeItem('cart');
    } else {
        syncCartToSessionStorage();
    }

    const cartItems = JSON.parse(sessionStorage.getItem('cart') || '{}');
    const cartCount = Object.values(cartItems).reduce((sum, item) => sum + (item.quantity || 0), 0);
    updateCartCounter(cartCount);
            // ✅ حساب المجموع والضريبة عند أول تحميل
let initialSubtotal = 0;
document.querySelectorAll('.item-subtotal').forEach(el => {
    const value = parseFloat(el.textContent.replace('$', '')) || 0;
    initialSubtotal += value;
});
updateTotalDisplay(initialSubtotal);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const cartBody = document.getElementById('cart-body');
            const submitOrderBtn = document.getElementById('submitOrderBtn');
            const checkoutSection = document.getElementById('checkout-section');
            const checkoutForm = document.getElementById('checkout-form');
            const phoneInput = document.querySelector("#phone-input");
            const fullPhoneInput = document.querySelector("#full-phone");
            
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "jo", // 🇯🇴 الأردن أول دولة
                preferredCountries: ["jo", "ae", "eg", "us", "gb"],
                separateDialCode: true,
                nationalMode: false,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"
            });
        //     checkBusinessHours(); 

        //     function checkBusinessHours() {
        //     const now = new Date();
        //     const currentHour = now.getHours();
        //     const currentMinutes = now.getMinutes();

        //     const currentTimeInMinutes = currentHour * 60 + currentMinutes;

        //     const openingTime = 12 * 60;       // 12:00 PM = 720
        //     const closingTime = 23 * 60 + 30;  // 11:30 PM = 1410

        //     if (currentTimeInMinutes < openingTime || currentTimeInMinutes > closingTime) {
        //         Swal.fire({
        //             icon: 'info',
        //             title: 'المطعم مغلق / Restaurant Closed',
        //             html: `
        //                 <p style="font-size:16px;">
        //                     نحن حالياً خارج ساعات العمل.<br>
        //                     ساعات العمل: من الساعة <strong>12:00 ظهرًا</strong> إلى <strong>11:30 مساءً</strong>.<br><br>
        //                     We are currently <strong>closed</strong>.<br>
        //                     Working hours: <strong>12:00 PM</strong> to <strong>11:30 PM</strong>.
        //                 </p>
        //             `,
        //             confirmButtonText: 'حسنًا / OK',
        //             confirmButtonColor: '#ffbe33',
        //             allowOutsideClick: false,
        //             allowEscapeKey: false
        //         }).then(() => {
        //             // تعطيل زر التأكيد
        //             const confirmBtn = document.getElementById('submitOrderBtn');
        //             if (confirmBtn) {
        //                 confirmBtn.disabled = true;
        //                 confirmBtn.style.opacity = 0.6;
        //                 confirmBtn.style.cursor = 'not-allowed';
        //             }

        //             // إخفاء الفورم
        //             const checkoutSection = document.getElementById('checkout-section');
        //             if (checkoutSection) checkoutSection.style.display = 'none';

        //             // تفريغ cart من الصفحة
        //             const cartBody = document.getElementById('cart-body');
        //             if (cartBody) {
        //                 cartBody.innerHTML = `
        //                     <tr id="empty-cart-row">
        //                         <td colspan="5" class="py-4">
        //                             <div class="text-center">
        //                                 <i class="fa fa-shopping-cart fa-3x mb-3 text-muted"></i>
        //                                 <h5>Your cart is empty</h5>
        //                                 <p class="text-muted">Add some delicious items from our menu!</p>
        //                                 <a href="/menu" class="btn btn-warning mt-3">Browse Menu</a>
        //                             </div>
        //                         </td>
        //                     </tr>
        //                 `;
        //             }

        //             const totalsSection = document.getElementById('cart-totals-section');
        //             if (totalsSection) totalsSection.style.display = 'none';

        //             document.querySelectorAll('.cart-count').forEach(el => {
        //                 el.textContent = '0';
        //                 el.classList.remove('show');
        //             });

        //             sessionStorage.removeItem('cart');

        //             // تفريغ session من السيرفر
        //             fetch('/cart/clear', {
        //                 method: 'POST',
        //                 headers: {
        //                     'X-CSRF-TOKEN': csrfToken,
        //                     'Content-Type': 'application/json',
        //                     'X-Requested-With': 'XMLHttpRequest'
        //                 }
        //             });

        //             // 🔁 إعادة توجيه المستخدم للصفحة الرئيسية
        //             window.location.href = "/";
        //         });
        //     }
        // }

function syncCartToSessionStorage() {
    const cartData = {};
    
    document.querySelectorAll('#cart-body tr[data-id]').forEach(row => {
        const id = row.dataset.id;
        const nameElement = row.querySelector('.dish-name');
        const name = nameElement ? nameElement.textContent.trim() : '';
        
        // الحصول على السعر من العمود المعروض
        const priceText = row.children[1].textContent.replace('$', '');
        const price = parseFloat(priceText) || 0;
        
        const quantity = parseInt(row.querySelector('.qty-number').textContent) || 1;
        
        const imgElement = row.querySelector('.dish-image img');
        const image = imgElement ? imgElement.getAttribute('src').replace('/storage/', '') : '';

        // جلب الإضافات
        let options = [];
        try {
            options = JSON.parse(row.dataset.options || '[]');
        } catch (e) {
            options = [];
        }

        // استخراج menu_item_id
        let menuItemId;
        if (id.includes('-')) {
            menuItemId = parseInt(id.split('-')[0]);
        } else {
            menuItemId = parseInt(id);
        }

        cartData[id] = {
            name: name,
            price: price,
            quantity: quantity,
            image: image,
            menu_item_id: menuItemId,
            options: options
        };
    });

    sessionStorage.setItem('cart', JSON.stringify(cartData));
    
    // ✅ حدث العداد أيضاً عند المزامنة
    const totalCount = Object.values(cartData).reduce((sum, item) => sum + (item.quantity || 0), 0);
    updateCartCounter(totalCount);
    
    console.log('🔄 Cart synced to sessionStorage:', cartData);
}


// 🔧 Event Listeners محسنة لأزرار + و -
document.addEventListener('DOMContentLoaded', function() {
    const cartBody = document.getElementById('cart-body');
    
    if (cartBody) {
        cartBody.addEventListener('click', function(e) {
            const row = e.target.closest('tr');
            if (!row || !row.dataset.id) return;
            
            const itemId = row.dataset.id;
            const qtySpan = row.querySelector('.qty-number');
            
            if (!qtySpan) return;
            
            const currentQty = parseInt(qtySpan.textContent.trim()) || 1;

            if (e.target.classList.contains('qty-plus')) {
                console.log('➕ Plus button clicked for item:', itemId);
                const newQty = currentQty + 1;
                updateCartItemQuantity(itemId, newQty, row);
                
            } else if (e.target.classList.contains('qty-minus')) {
                console.log('➖ Minus button clicked for item:', itemId);
                
                if (currentQty > 1) {
                    const newQty = currentQty - 1;
                    updateCartItemQuantity(itemId, newQty, row);
                } else {
                    console.log('⚠️ Cannot reduce quantity below 1');
                }
            }
        });
    }
    calculateAndUpdateCartCounter();
});

function updateCartItemQuantity(id, quantity, row) {
    const qtySpan = row.querySelector('.qty-number');
    const subtotalTd = row.querySelector('.item-subtotal');
    const priceCell = row.children[1]; // خانة السعر

    // 🟢 جلب السعر الأساسي للعنصر من الخانة المعروضة
    let displayedPrice = parseFloat(priceCell.textContent.replace('$', '')) || 0;

    // 🟢 جلب الإضافات من data-options
    let options = [];
    try {
        options = JSON.parse(row.dataset.options || '[]');
    } catch (e) {
        console.warn('Invalid options:', e);
        options = [];
    }

    // 🟢 السعر النهائي = السعر المعروض (يتضمن الإضافات بالفعل)
    const finalPrice = displayedPrice;

    // 🟢 حساب المجموع الفرعي
    const itemSubtotal = finalPrice * quantity;

    // 🟢 تحديث الواجهة أولاً
    qtySpan.textContent = quantity;
    subtotalTd.textContent = `$${itemSubtotal.toFixed(2)}`;

    // ✅ حساب المجموع الكلي الصحيح من DOM مباشرة
    calculateAndUpdateTotal();

    // 🟢 استخراج menu_item_id الصحيح
    let menuItemId;
    if (id.includes('-')) {
        menuItemId = parseInt(id.split('-')[0]);
    } else {
        menuItemId = parseInt(id);
    }

    // 🟢 إرسال البيانات للسيرفر
    fetch('/cart/ajax-add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            menu_item_id: menuItemId,
            quantity: quantity,
            options: options,
            final_price: finalPrice
        })
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        console.log('✅ Cart updated successfully:', data);
        
        // ✅ استخدم الحساب المحلي بدلاً من بيانات السيرفر
        calculateAndUpdateTotal();

        // ✅ احسب العداد محلياً
        calculateAndUpdateCartCounter();

        // 🟢 تحديث sessionStorage
        syncCartToSessionStorage();
    })
    .catch(error => {
        console.error('❌ Error updating cart item:', error);
        
        // 🟢 في حالة الخطأ، أرجع القيم للحالة السابقة
        const previousQty = quantity > 1 ? quantity - 1 : quantity + 1;
        qtySpan.textContent = previousQty;
        subtotalTd.textContent = `$${(finalPrice * previousQty).toFixed(2)}`;
        
        // ✅ أعد حساب المجموع بعد الإرجاع
        calculateAndUpdateTotal();
        
        showNotification('فشل في تحديث الكمية، الرجاء المحاولة مرة أخرى', 'error');
    });
}

function calculateAndUpdateTotal() {
    let subtotal = 0;
    
    // احسب المجموع من جميع العناصر الموجودة في الجدول
    document.querySelectorAll('#cart-body tr[data-id]').forEach(row => {
        const subtotalCell = row.querySelector('.item-subtotal');
        if (subtotalCell) {
            const itemSubtotal = parseFloat(subtotalCell.textContent.replace('$', '')) || 0;
            subtotal += itemSubtotal;
        }
    });
    
    // تحديث العرض
    updateTotalDisplay(subtotal);
    
    console.log('🧮 Calculated total from DOM:', subtotal);
    return subtotal;
}

function calculateAndUpdateCartCounter() {
    let totalCount = 0;
    
    // احسب العدد الكامل من جميع العناصر في الجدول
    document.querySelectorAll('#cart-body tr[data-id] .qty-number').forEach(qtySpan => {
        const quantity = parseInt(qtySpan.textContent.trim()) || 0;
        totalCount += quantity;
    });
    
    // حدث العداد
    updateCartCounter(totalCount);
    
    console.log('🔄 Cart counter calculated locally:', totalCount);
}
function updateCartCounter(count) {
    document.querySelectorAll('.cart-count, #cart-count, #floating-cart-count').forEach(el => {
        el.textContent = count;
        el.classList.toggle('show', count > 0);
    });
    
    console.log('🛒 Cart counter updated:', count);
}
            function showEmptyCartMessage() {
                const totalsSection = document.getElementById('cart-totals-section');
                const checkoutSection = document.getElementById('checkout-section');
                if (totalsSection) totalsSection.style.display = 'none';
                if (checkoutSection) checkoutSection.style.display = 'none';

                if (!document.getElementById('empty-cart-row')) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.id = 'empty-cart-row';
                    emptyRow.innerHTML = `
                        <td colspan="5" class="py-4">
                            <div class="text-center">
                                <i class="fa fa-shopping-cart fa-3x mb-3 text-muted"></i>
                                <h5>Your cart is empty</h5>
                                <p class="text-muted">Add some delicious items from our menu!</p>
                                <a href="/menu" class="btn btn-warning mt-3">Browse Menu</a>
                            </div>
                        </td>`;
                    document.getElementById('cart-body').appendChild(emptyRow);
                }
            }

function showNotification(message, type = 'success') {
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    const toast = document.createElement('div');
    toast.className = `toast ${type === 'error' ? 'bg-danger' : 'bg-success'} text-white`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="toast-header ${type === 'error' ? 'bg-danger' : 'bg-success'} text-white">
            <strong class="me-auto">${type === 'error' ? 'خطأ' : 'نجح'}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">${message}</div>`;
    
    toastContainer.appendChild(toast);

    // استخدام Bootstrap Toast إذا كان متوفراً
    if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    } else {
        // عرض يدوي للتوست
        toast.style.display = 'block';
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
}

            function formatTime(time) {
                return time?.length === 5 ? time + ':00' : time;
            }

            if (cartBody) {
                cartBody.addEventListener('click', function(e) {
                    const row = e.target.closest('tr');
                    if (!row) return;
                    const itemId = row.dataset.id;

                    if (e.target.classList.contains('btn-remove')) {
                       Swal.fire({
                        title: messages.remove_title,
                        text: messages.remove_text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ffbe33',
                        cancelButtonColor: '#aaa',
                        confirmButtonText: messages.remove_yes,
                        cancelButtonText: messages.cancel,
                        reverseButtons: true
                    }).then(result => {
                        if (result.isConfirmed) {
                            row.classList.add('cart-row-remove');
                            setTimeout(() => {
                                fetch('/cart/remove', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: JSON.stringify({
                                        menu_item_id: itemId
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    row.remove(); // احذف العنصر من الـ DOM

                                    updateTotalDisplay(data.total); // حدث السعر
                                    updateCartCounter(data.count);  // حدث العداد

                                    // ✅ أضف هذا السطر لمسح العنصر من sessionStorage
                                    const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                                    delete cart[itemId];
                                    sessionStorage.setItem('cart', JSON.stringify(cart));

                                    if (data.count === 0 || document.querySelectorAll('#cart-body tr[data-id]').length === 0) {
                                        showEmptyCartMessage();
                                        sessionStorage.removeItem('cart'); // ✅ نظف كامل الجلسة
                                    }

                                    Swal.fire({
                                        icon: 'success',
                                        title: messages.removed_title,
                                        text: messages.removed_text,
                                        confirmButtonText: messages.ok
                                    });
                                })
                                .catch(error => {
                                    console.error('Error removing item:', error);
                                    row.classList.remove('cart-row-remove');
                                    showNotification(messages.remove_failed, 'error');
                                });
                            }, 300);
                        }
                    });
} else if (e.target.classList.contains('qty-plus')) {
    const qtySpan = row.querySelector('.qty-number');
    const currentQty = parseInt(qtySpan.textContent.trim());
    const newQty = currentQty + 1;
    updateCartItemQuantity(itemId, newQty, row);
} else if (e.target.classList.contains('qty-minus')) {
    const qtySpan = row.querySelector('.qty-number');
    const currentQty = parseInt(qtySpan.textContent.trim());
    if (currentQty > 1) {
        const newQty = currentQty - 1;
        updateCartItemQuantity(itemId, newQty, row);
    }
}

                });
            }

            // ✅ الكود المعدل لـ submitOrderBtn مع تحسينات
// هذا الجزء يفترض وجود عناصر DOM التي تشير إليها
// تعرف أن هذه هي فقط أجزاء من الكود الكامل

if (submitOrderBtn) {
    submitOrderBtn.addEventListener('click', function () {

        // التحقق من الوقت
        const timeInput = document.getElementById('preferredTime');
        const timeError = document.getElementById('time-error');
        const timeValue = timeInput.value;

        if (timeValue < "12:30" || timeValue > "23:30") {
            timeInput.classList.add('is-invalid');
            timeError.classList.remove('d-none');
            timeInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        } else {
            timeInput.classList.remove('is-invalid');
            timeError.classList.add('d-none');
        }

        // التحقق من صحة النموذج
        if (!checkoutForm.checkValidity()) {
            // عرض رسائل الخطأ الافتراضية
            checkoutForm.reportValidity();

            // إضافة أنيميشن وشرح عند الحقول غير الصالحة
            const invalidFields = checkoutForm.querySelectorAll(':invalid');
            invalidFields.forEach(field => {
                field.classList.add('is-invalid');
                field.addEventListener('input', () => field.classList.remove('is-invalid'));

                // إذا لم يوجد شرح تحته، أضف شرح
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorMsg = document.createElement('div');
                    errorMsg.classList.add('invalid-feedback');
                    errorMsg.textContent = field.title || 'Please correct this field.';
                    field.parentNode.appendChild(errorMsg);
                }
            });

            return;
        }

        // التحقق من صحة البريد الإلكتروني
        const emailInput = document.querySelector('[name="customer_email"]');
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        if (!emailInput.value || !emailPattern.test(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            
            // إضافة رسالة خطأ إذا لم تكن موجودة
            if (!emailInput.nextElementSibling || !emailInput.nextElementSibling.classList.contains('invalid-feedback')) {
                const errorMsg = document.createElement('div');
                errorMsg.classList.add('invalid-feedback');
                errorMsg.textContent = 'Please enter a valid email address';
                emailInput.parentNode.appendChild(errorMsg);
            }
            
            emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        } else {
            emailInput.classList.remove('is-invalid');
            const errorMsg = emailInput.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                errorMsg.remove();
            }
        }

        const thankYouMessageElement = document.querySelector('.text-center.mt-5 p');
        const thankYouMessage = thankYouMessageElement ? thankYouMessageElement.innerHTML : '';

        Swal.fire({
            icon: 'success',
            title: @json(__('cart.order_confirmed_title')),
            html: @json(__('cart.order_confirmed_text')) + '<br><br>' +
                '<div style="font-size: 18px; color: #666; margin-top: 10px;">' +
                thankYouMessage + '</div>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ffbe33',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(result => {
            if (result.isConfirmed) {
                const fullPhoneNumber = iti.getNumber();
                document.getElementById('full-phone').value = fullPhoneNumber;
                
                // تجميع بيانات النموذج
                const formData = new FormData(checkoutForm);
                const formDataObj = Object.fromEntries(formData);
                
                // الحصول على بيانات السلة من sessionStorage
                const cartItems = JSON.parse(sessionStorage.getItem('cart') || '{}');

                const formattedCart = Object.entries(cartItems).map(([key, item]) => {
    let menuItemId;

    // استخدم menu_item_id الصحيح من العنصر وليس من key
    if (item.menu_item_id && !isNaN(parseInt(item.menu_item_id))) {
        menuItemId = parseInt(item.menu_item_id);
    } else if (typeof key === 'string' && key.includes('-')) {
        const parts = key.split('-');
        menuItemId = parseInt(parts[0]);
    } else {
        console.warn("Invalid menu_item_id for item:", item);
    }

    return {
        menu_item_id: menuItemId,  // ✅ فقط رقم
        quantity: item.quantity,
        price: item.price,
        options: item.options || []
    };
});


                
                // تجهيز البيانات للإرسال مع إضافة البريد الإلكتروني والسلة
                const requestData = {
                ...formDataObj,
                cart: formattedCart,
                customer_email: document.querySelector('[name="customer_email"]').value
            };

             console.log("📦 Sending requestData to server:", requestData);


                // إرسال الطلب مع البيانات الكاملة
                fetch("/cart/place-order", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(requestData)
            })
                .then(res => res.json())
            .then(data => {
                    if (data.status === 'ok') {

                         // ✅ تفريغ التخزين المحلي والجلسة
                sessionStorage.setItem('order_sent', '1');
                sessionStorage.removeItem('cart');
                updateCartCounter(0);

                            
                        checkoutForm.style.display = 'none';
                        if (checkoutSection) {
                            checkoutSection.style.display = 'none';
                        }

                        // ✅ Scroll لفوق
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });

                        const cartBody = document.getElementById('cart-body');
                        if (cartBody) {
                            const rows = cartBody.querySelectorAll('tr[data-id]');
                            rows.forEach(row => row.classList.add('cart-row-remove'));

                            setTimeout(() => {
                                rows.forEach(row => row.remove());

                                if (!document.getElementById('empty-cart-row')) {
                                    const emptyRow = document.createElement('tr');
                                    emptyRow.id = 'empty-cart-row';
                                    emptyRow.innerHTML = `
                                        <td colspan="5" class="py-4">
                                            <div class="text-center">
                                                <i class="fa fa-shopping-cart fa-3x mb-3 text-muted"></i>
                                                <h5>Your cart is empty</h5>
                                                <p class="text-muted">Add some delicious items from our menu!</p>
                                                <a href="/menu" class="btn btn-warning mt-3">Browse Menu</a>
                                            </div>
                                        </td>`;
                                    cartBody.appendChild(emptyRow);
                                }

                                const totalsSection = document.getElementById('cart-totals-section');
                                if (totalsSection) totalsSection.style.display = 'none';

                                document.querySelectorAll('.cart-count').forEach(el => {
                                    el.textContent = '0';
                                    el.classList.remove('show');
                                });

                                sessionStorage.removeItem('cart');

                                Swal.fire({
                                    icon: 'success',
                                    title: @json(__('cart.order_success_popup_title')),
                                    text: @json(__('cart.order_success_popup_text')),
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffbe33'
                                });
                            }, 300);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: @json(__('cart.order_error_title')),
                            text: @json(__('cart.order_error_text')),
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#dc3545'
                        });
                    }

                })
                .catch(error => {
                    console.error("Order submission error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was a problem sending your order. Please try again.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                });
            }
        });
    });
}

        }); // ← نهاية DOMContentLoaded

        // ✅ الدوال العامة خارج DOMContentLoaded
        function showCheckoutForm() {
            const checkoutSection = document.getElementById('checkout-section');
            if (checkoutSection) {
                checkoutSection.style.display = 'block';
                window.scrollTo({
                    top: checkoutSection.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        }

function selectOrderType(type) {
    const orderTypeInput = document.getElementById('order_type');
    const timeInput = document.getElementById('preferredTime');
    const pickupBtn = document.getElementById('pickupBtn');
    const deliveryBtn = document.getElementById('deliveryBtn');
    const pickupRecipientGroup = document.getElementById('pickup-recipient-group');
    const addressGroup = document.getElementById('address-group');
    const addressInput = document.querySelector('[name="address"]');

    // تحديد نوع الطلب في الفورم
    orderTypeInput.value = type;
    document.getElementById('checkout-form').style.display = 'block';

    // حساب الوقت الحالي + 30 دقيقة
    const now = new Date();
    now.setMinutes(now.getMinutes() + 30);

    let hours = now.getHours().toString().padStart(2, '0');
    let minutes = now.getMinutes().toString().padStart(2, '0');
    const minTime = `${hours}:${minutes}`;

    // الحد الأقصى للطلب: 11:30 PM
    const maxTime = "23:30";

    // تحديد min و max
    timeInput.min = minTime;
    timeInput.max = maxTime;

    // تعيين القيمة الافتراضية للوقت (مراعاة حالات خاصة)
    if (minTime > maxTime) {
        timeInput.value = maxTime; // إذا مر الوقت، حط آخر وقت
    } else {
        timeInput.value = minTime;
    }

    // تهيئة الحقول حسب نوع الطلب
    if (type === 'pickup') {
        timeInput.setAttribute('name', 'pickup_time');
        pickupRecipientGroup.style.display = 'block';
        addressGroup.style.display = 'none';
        addressInput.removeAttribute('required');
    } else {
        timeInput.setAttribute('name', 'delivery_time');
        pickupRecipientGroup.style.display = 'none';
        addressGroup.style.display = 'block';
        addressInput.setAttribute('required', 'required');
    }

    // إزالة المؤثر البصري السابق
    document.querySelectorAll('.order-type-btn').forEach(btn => {
        btn.classList.remove('order-type-btn');
    });
}

    </script>

@endsection
