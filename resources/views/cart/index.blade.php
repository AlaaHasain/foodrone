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
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.css" />
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"></script>

@section('content')
    {{-- Header --}}
    @include('layouts.partials.header')

    @if (request('cleared'))
        @php session()->forget('cart'); @endphp
    @endif

    <section class="cart_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-4">
                <h2>Your Cart</h2>
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
                            <th>Dish</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        @php $total = 0; @endphp
                        @forelse ($cart as $id => $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr data-id="{{ $id }}">
                                <td class="d-flex align-items-center">
                                    @if (isset($item['image']) && !empty($item['image']))
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                            class="img-thumbnail me-2"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @endif
                                    <span>{{ $item['name'] }}</span>
                                </td>
                                <td>${{ number_format($item['price'], 2) }}</td>
                                <td>
                                    <div class="qty-controls d-flex justify-content-center align-items-center">
                                        <button class="btn btn-sm btn-outline-dark qty-minus">−</button>
                                        <span class="mx-2 qty-number">{{ $item['quantity'] }}</span>
                                        <button class="btn btn-sm btn-outline-dark qty-plus">+</button>
                                    </div>
                                </td>
                                <td class="item-subtotal">${{ number_format($subtotal, 2) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger btn-remove">Remove</button>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-cart-row">
                                <td colspan="5" class="py-4">
                                    <div class="text-center">
                                        <i class="fa fa-shopping-cart fa-3x mb-3 text-muted"></i>
                                        <h5>Your cart is empty</h5>
                                        <p class="text-muted">Add some delicious items from our menu!</p>
                                        <a href="{{ route('menu') }}" class="btn btn-warning mt-3">Browse Menu</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (!empty($cart))
                <div class="text-center mt-4" id="cart-totals-section">
                    <h4>Total: $<span id="cart-total">{{ number_format($total, 2) }}</span></h4>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                        <a href="{{ route('menu') }}" class="btn btn-secondary btn-continue px-4 py-2">← Continue
                            Ordering</a>
                        <button type="button" class="btn btn-warning btn-checkout px-4 py-2"
                            onclick="showCheckoutForm()">Proceed to Checkout</button>
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
                    <h2>Checkout</h2>
                </div>

                <div class="text-center mb-3">
                    <i class="fas fa-hand-pointer fa-lg text-warning"></i>
                    <span class="fw-bold" style="font-size: 17px; color: #444;">
                        Please select your order type to continue
                    </span>
                </div>

                <div class="text-center mb-4">
                    <button id="pickupBtn" class="btn btn-outline-secondary me-2 order-type-btn"
                        onclick="selectOrderType('pickup')">Pick Up</button>
                    <button id="deliveryBtn" class="btn btn-outline-secondary order-type-btn"
                        onclick="selectOrderType('delivery')">Delivery</button>
                </div>

                <form action="{{ route('cart.placeOrder') }}" method="POST" class="bg-white p-4 rounded shadow-lg"
    id="checkout-form" style="display:none; max-width: 600px; margin: auto;">
    <div id="closed-warning" class="alert alert-warning text-center fw-bold d-none" role="alert">
        نحن حالياً خارج أوقات الدوام. الرجاء المحاولة لاحقًا.<br>
        <small>We are currently outside working hours. Please try again later.</small>
    </div>
    
    @csrf

    <input type="hidden" name="order_type" id="order_type">

    {{-- الاسم --}}
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" placeholder="e.g. John Doe"
               pattern="^[A-Za-z]{2,}\s[A-Za-z]{2,}.*$" title="Please enter at least first and last name" required>
    </div>

    {{-- رقم الهاتف مع اختيار الدولة --}}
    <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="tel" name="phone" id="phone-input" class="form-control" required>
    </div>
    <input type="hidden" name="full_phone" id="full-phone">
    
 {{-- حقل البريد الإلكتروني --}}
 <div class="mb-3">
    <label class="form-label">Email Address</label>
    <input type="email" name="customer_email" class="form-control" placeholder="e.g. yourname@example.com" required
           pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
           title="Please enter a valid email address">
</div>


    {{-- اسم المستلم (لـ Pick Up) --}}
    <div class="mb-3" id="pickup-recipient-group" style="display: none;">
        <label class="form-label">Receiver Name</label>
        <input type="text" name="pickup_receiver" class="form-control"
               placeholder="Name of the person who will pick it up"
               pattern="^[A-Za-z]{2,}\s[A-Za-z]{2,}.*$"
               title="Please enter at least first and last name">
    </div>

    {{-- الموقع (للتوصيل فقط) --}}
    <div class="mb-3" id="address-group" style="display: none;">
        <label class="form-label">Delivery Address</label>
        <input type="text" name="address" class="form-control" placeholder="e.g. Amman, 7th Circle">
    </div>

    {{-- موعد الاستلام/التوصيل --}}
    <input type="time"
       name="pickup_time"
       id="preferredTime"
       class="form-control"
       required>
<div id="time-error" class="invalid-feedback d-none">
    Please choose a time between 12:30 PM and 11:30 PM.
</div>

    

    {{-- الملاحظات --}}
    <div class="mb-3">
        <label class="form-label">Notes (optional)</label>
        <textarea name="notes" class="form-control" placeholder="Any special instructions?"></textarea>
    </div>

    {{-- الدفع --}}
    <div class="mb-4">
        <label class="form-label d-block mb-2">Payment Method</label>
        <div class="custom-radio-group justify-content-start">
            <input type="radio" id="payment_cash" name="payment_method" value="cash" checked hidden>
            <label for="payment_cash" class="radio-option">
                <i class="fas fa-money-bill-wave me-2"></i> Cash
            </label>

            <input type="radio" id="payment_visa" name="payment_method" value="visa" hidden>
            <label for="payment_visa" class="radio-option">
                <i class="fas fa-credit-card me-2"></i> Visa
            </label>
        </div>
    </div>

    <div class="text-center">
        <button type="button" id="submitOrderBtn" class="btn btn-warning btn-lg px-5">Confirm Order</button>
    </div>
</form>

                <div class="text-center mt-5">
                    <p style="font-size: 18px; color: #666;">
                        Thank you for visiting
                        <strong>
                            <span style="color: #a4c762;">Lemon</span><span style="color: #ffbe33;">grass</span>
                        </strong>! 🌿<br>
                        We hope you enjoy your meal.
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
                        ← Back to Home
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // تنظيم الكود وإزالة التكرارات
        document.addEventListener('DOMContentLoaded', function() {
            
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
                    const name = row.querySelector('td span')?.textContent;
                    const price = parseFloat(row.children[1].textContent.replace('$', ''));
                    const quantity = parseInt(row.querySelector('.qty-number').textContent);
                    const image = row.querySelector('img')?.getAttribute('src') || '';
                    cartData[id] = {
                        name,
                        price,
                        quantity,
                        image
                    };
                });
                sessionStorage.setItem('cart', JSON.stringify(cartData));
            }

            function updateTotalDisplay(total) {
                const totalEl = document.getElementById('cart-total');
                if (totalEl) {
                    totalEl.textContent = typeof total === 'number' ? total.toFixed(2) : '0.00';
                    totalEl.classList.add('animate');
                    setTimeout(() => totalEl.classList.remove('animate'), 400);
                }
            }

            function updateCartCounter(count) {
                document.querySelectorAll('#cart-count').forEach(el => {
                    el.textContent = count;
                    el.classList.toggle('show', count > 0);
                });
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
                    document.body.appendChild(toastContainer);
                }

                const toast = document.createElement('div');
                toast.className = `toast ${type === 'error' ? 'bg-danger' : 'bg-success'} text-white`;
                toast.setAttribute('role', 'alert');
                toast.innerHTML = `
                    <div class="toast-header ${type === 'error' ? 'bg-danger' : 'bg-success'} text-white">
                        <strong class="me-auto">${type === 'error' ? 'error' : 'success'}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">${message}</div>`;
                toastContainer.appendChild(toast);

                new bootstrap.Toast(toast).show();
                toast.addEventListener('hidden.bs.toast', () => toast.remove());
            }

            function updateCartItemQuantity(id, quantity, row) {
                const qtySpan = row.querySelector('.qty-number');
                const subtotalTd = row.querySelector('.item-subtotal');
                const price = parseFloat(row.children[1].textContent.replace('$', ''));

                qtySpan.textContent = quantity;
                subtotalTd.textContent = `$${(price * quantity).toFixed(2)}`;

                fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            menu_item_id: id,
                            quantity
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        updateTotalDisplay(data.total);
                        updateCartCounter(data.count);
                        syncCartToSessionStorage();
                    })
                    .catch(error => {
                        console.error('Error updating quantity:', error);
                        showNotification('فشل في تحديث الكمية', 'error');
                        qtySpan.textContent = quantity - 1;
                        subtotalTd.textContent = `$${(price * (quantity - 1)).toFixed(2)}`;
                    });
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
                            title: 'Are you sure?',
                            text: "Do you want to remove this item from the cart?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ffbe33',
                            cancelButtonColor: '#aaa',
                            confirmButtonText: 'Yes, remove it!',
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
                                            row.remove();
                                            updateTotalDisplay(data.total);
                                            updateCartCounter(data.count);
                                            syncCartToSessionStorage();
                                            if (data.count === 0 || document
                                                .querySelectorAll(
                                                    '#cart-body tr[data-id]').length ===
                                                0) {
                                                showEmptyCartMessage();
                                            }
                                            Swal.fire('Removed!',
                                                'The item has been removed.',
                                                'success');
                                        })
                                        .catch(error => {
                                            console.error('Error removing item:',
                                                error);
                                            row.classList.remove('cart-row-remove');
                                            showNotification('Failed to remove item.',
                                                'error');
                                        });
                                }, 300);
                            }
                        });
                    } else if (e.target.classList.contains('qty-plus')) {
                        const qtySpan = row.querySelector('.qty-number');
                        let quantity = parseInt(qtySpan.textContent) + 1;
                        updateCartItemQuantity(itemId, quantity, row);
                    } else if (e.target.classList.contains('qty-minus')) {
                        const qtySpan = row.querySelector('.qty-number');
                        let quantity = parseInt(qtySpan.textContent);
                        if (quantity > 1) {
                            quantity--;
                            updateCartItemQuantity(itemId, quantity, row);
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
            title: 'Order Confirmed!',
            html: 'Your request has been sent successfully!<br><br>' +
                '<div style="font-size: 18px; color: #666; margin-top: 10px;">' +
                thankYouMessage + '</div>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ffbe33',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(result => {
            if (result.isConfirmed) {
                const fullPhoneNumber = iti.getNumber(); // ✅ أضف هذا
                document.getElementById('full-phone').value = fullPhoneNumber;
                
                // تجميع بيانات النموذج
                const formData = new FormData(checkoutForm);
                const formDataObj = Object.fromEntries(formData);
                
                // الحصول على بيانات السلة من sessionStorage
                const cartItems = JSON.parse(sessionStorage.getItem('cart') || '[]');
                
                // تجهيز البيانات للإرسال مع إضافة البريد الإلكتروني والسلة
                const requestData = {
                    ...formDataObj,
                    cart: cartItems,
                    customer_email: document.querySelector('[name="customer_email"]').value // تأكيد إرسال البريد الإلكتروني
                };

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
                                    title: 'Thank You!',
                                    text: 'Your order has been placed successfully.',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffbe33'
                                });
                            }, 300);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'There was a problem sending your order. Please try again.',
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
    document.getElementById('order_type').value = type;
    document.getElementById('checkout-form').style.display = 'block';

    const now = new Date();
    now.setMinutes(now.getMinutes() + 30);
    const maxTime = new Date();
    maxTime.setHours(23, 30, 0);

    const timeInput = document.getElementById('preferredTime');
    const pickupBtn = document.getElementById('pickupBtn');
    const deliveryBtn = document.getElementById('deliveryBtn');
    const pickupRecipientGroup = document.getElementById('pickup-recipient-group');
    const addressGroup = document.getElementById('address-group');
    const addressInput = document.querySelector('[name="address"]');

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

    timeInput.min = "12:30";
timeInput.max = "23:30";

const nowTime = now.toTimeString().slice(0, 5);

if (nowTime < "12:30") {
    timeInput.value = "12:30";
} else if (nowTime > "23:30") {
    timeInput.value = "23:30";
} else {
    timeInput.value = nowTime;
}

    document.querySelectorAll('.order-type-btn').forEach(btn => {
        btn.classList.remove('order-type-btn');
    });
}
    </script>

@endsection
