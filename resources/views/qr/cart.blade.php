@extends('layouts.app')

@section('title', 'QR Cart')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

@php
    $cart = session('qr_cart', []);
    $token = request()->query('token') ?? session('qr_token'); // ✅ حماية التوكن
@endphp

@if($token)
    @php session(['qr_token' => $token]); @endphp
@endif

<style>
    .method-btn {
        padding: 10px 18px;
        border-radius: 30px;
        font-weight: 600;
        background-color: #e8f6ee;
        color: #2a5f2d;
        cursor: pointer;
        transition: 0.3s ease;
        border: 2px solid transparent;
    }
    input[type="radio"]:checked + .method-btn {
        background-color: #2a5f2d;
        color: white;
        border-color: #2a5f2d;
    }
    .method-btn i {
        margin-right: 6px;
    }

    @media (max-width: 576px) {
    table thead {
        display: none;
    }

    table tbody tr {
        display: block;
        margin-bottom: 20px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    table tbody tr td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        font-size: 14px;
        border: none;
        border-bottom: 1px solid #eee;
    }

    table tbody tr td:last-child {
        border-bottom: none;
    }

    table tbody tr td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #555;
        flex: 1;
        max-width: 50%;
    }

    .qr-qty {
        min-width: 30px;
        text-align: center;
    }

    .d-flex.justify-content-center.align-items-center {
        flex-wrap: wrap;
    }
}
/* تحسين عرض الكارت بدون صورة */
#qr-cart-body td {
    vertical-align: top;
    padding: 12px 10px;
}

#qr-cart-body strong {
    font-size: 15px;
    color: #2a5f2d;
}

#qr-cart-body ul {
    padding-left: 15px;
    margin-top: 5px;
}

@media (max-width: 768px) {
    #qr-cart-body td {
        font-size: 13px;
    }

    .qr-qty {
        font-size: 14px;
    }

    .qr-remove, .qr-qty-plus, .qr-qty-minus {
        font-size: 12px;
        padding: 4px 6px;
    }
}

</style>

<div class="container py-5" id="qr-cart-container">
    <h2 class="text-center mb-4">Your QR Cart</h2>

    <div id="empty-cart-message" style="display: {{ empty($cart) ? 'block' : 'none' }}">
        <div class="alert alert-info text-center">Your QR cart is empty.</div>
        <div class="text-center">
            <a href="{{ route('menu.qr.view', ['token' => $token]) }}" class="btn btn-warning">← Browse Menu</a>
        </div>
    </div>

    <div id="viewOrderContainer" class="text-center mt-3" style="display: none;">
            <a href="#" id="viewMyOrderBtn" class="btn btn-outline-success btn-lg">
                🧾 View My Order
            </a>
    </div>
    <div id="cart-content" style="display: {{ empty($cart) ? 'none' : 'block' }}">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Dish</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="qr-cart-body">
                    @php $total = 0; @endphp
                    @foreach ($cart as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr data-id="{{ $id }}">
                            <td class="text-start" data-label="Dish">
                                <strong>{{ $item['name'] }}</strong>
                                @if(!empty($item['options']))
                                    <ul class="mb-0 ps-3 small text-muted">
                                        @foreach($item['options'] as $option)
                                            @if(isset($option['additional_price']) && $option['additional_price'] > 0)
                                                <li>{{ $option['value'] ?? '' }} (+{{ number_format($option['additional_price'], 2) }} JOD)</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td data-label="Price">${{ number_format($item['price'], 2) }}</td>
                            <td data-label="Quantity">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-sm btn-dark me-1 qr-qty-minus">−</button>
                                    <span class="fw-bold mx-2 qr-qty">{{ $item['quantity'] }}</span>
                                    <button class="btn btn-sm btn-dark ms-1 qr-qty-plus">+</button>
                                </div>
                            </td>
                            <td class="qr-subtotal" data-label="Subtotal">${{ number_format($subtotal, 2) }}</td>
                            <td data-label="Action">
                                <button class="btn btn-sm btn-danger qr-remove">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

@php
    $taxRate = \App\Models\Setting::first()->order_tax_rate ?? 0;
    $taxAmount = $total * ($taxRate / 100);
    $totalWithTax = $total + $taxAmount;
@endphp
<div class="text-center mt-4">
    <h5>Subtotal: <span class="qr-subtotal-value fw-normal">${{ number_format($total, 2) }}</span></h5>
    <h5>Tax ({{ $taxRate }}%): <span class="qr-tax-value fw-normal">${{ number_format($taxAmount, 2) }}</span></h5>
    <h4 class="mt-2">Total: <span class="qr-total-value text-success">${{ number_format($totalWithTax, 2) }}</span></h4>
</div>


        <div class="text-center mt-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('menu.qr.view', ['token' => $token]) }}" class="btn btn-dark btn-lg">← Continue Ordering</a>
            <button id="showCheckoutForm" class="btn btn-success btn-lg">Proceed to Checkout</button>
        </div>

        <!-- Checkout form -->
        <div id="checkoutSection" class="card mt-5 shadow-sm" style="display: none; max-width: 700px; margin: auto;">
            <div class="card-body">
                <h4 class="mb-4 text-center text-success fw-bold">📟 Complete Your Order</h4>
                <form id="qrCheckoutFormFinal">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Your Name</label>
                            <input type="text" id="customer_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label">Phone Number</label>
                            <input type="text" id="customer_phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Method</label>
                            <div class="d-flex gap-3 justify-content-center">
                                <input type="radio" name="payment_method" id="pay_cash" value="cash" checked hidden>
                                <label for="pay_cash" class="method-btn"><i class="fas fa-money-bill-wave"></i> Cash</label>
                                <input type="radio" name="payment_method" id="pay_visa" value="visa" hidden>
                                <label for="pay_visa" class="method-btn"><i class="fas fa-credit-card"></i> Visa</label>
                            </div>
                        </div>
                        @php
                        $tableNumber = \App\Models\Table::where('qr_token', session('qr_token'))->value('table_number');
                        @endphp
                        <input type="hidden" id="table_number" value="{{ $tableNumber }}">
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-success w-100">✅ Confirm Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function fetchTaxCalculation() {
    console.log('🔄 Fetching tax...');
    fetch("{{ route('qr.tax.calculate') }}")
        .then(res => res.json())
        .then(data => {
            console.log('✅ Tax data:', data);
            document.querySelector('.qr-subtotal-value').textContent = `$${parseFloat(data.subtotal).toFixed(2)}`;
            document.querySelector('.qr-tax-value').textContent = `$${parseFloat(data.tax_amount).toFixed(2)}`;
            document.querySelector('.qr-total-value').textContent = `$${parseFloat(data.total).toFixed(2)}`;
        })
        .catch(err => console.error("Tax Fetch Error:", err));
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('qr_order_token');
    const container = document.getElementById('viewOrderContainer');

    if (token && container) {
        container.innerHTML = `
            <a href="/qr/order/${token}" class="btn btn-outline-success btn-lg">
                🧾 View My Order
            </a>
        `;
        container.style.display = 'block';
    }
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const token = @json($token);
    
        const updateCart = (id, quantity) => {
            fetch("{{ route('qr.cart.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ item_id: id, quantity })
            })
            .then(res => res.json())
            .then(data => {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    row.querySelector('.qr-qty').textContent = quantity;
                    row.querySelector('.qr-subtotal').textContent = '$' + data.subtotal.toFixed(2);
                }

fetchTaxCalculation();

document.querySelector('.qr-total-value').textContent = '$' + data.total.toFixed(2);
    
                const cartCounter = document.getElementById('floating-cart-count');
                if (cartCounter) {
                    cartCounter.textContent = data.count;
                }
            });
        };
    
        const refreshEventListeners = () => {
            document.querySelectorAll('.qr-qty-plus').forEach(btn => {
                btn.onclick = () => {
                    const row = btn.closest('tr');
                    const id = row.dataset.id;
                    const quantity = parseInt(row.querySelector('.qr-qty').textContent);
                    updateCart(id, quantity + 1);
                };
            });
    
            document.querySelectorAll('.qr-qty-minus').forEach(btn => {
                btn.onclick = () => {
                    const row = btn.closest('tr');
                    const id = row.dataset.id;
                    const quantity = parseInt(row.querySelector('.qr-qty').textContent);
                    if (quantity > 1) updateCart(id, quantity - 1);
                };
            });
    
            document.querySelectorAll('.qr-remove').forEach(btn => {
                btn.onclick = function () {
                    const row = this.closest('tr');
                    const id = row.dataset.id;
    
                    fetch("{{ route('qr.cart.remove') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ item_id: id })
                    })
                    .then(res => res.json())
                    .then(data => {
                        row.remove();
document.querySelector('.qr-total-value').textContent = '$' + data.total.toFixed(2);
    
                        const cartCounter = document.getElementById('floating-cart-count');
                        if (cartCounter) {
                            cartCounter.textContent = data.count;
                        }

fetchTaxCalculation();

    
if (data.count === 0) {
    document.getElementById('empty-cart-message')?.classList.remove('d-none');
    document.getElementById('empty-cart-message').style.display = 'block';

    document.getElementById('cart-content')?.classList.add('d-none');
    document.getElementById('cart-content').style.display = 'none';

    // كمان خفي الزر السفلي
    document.getElementById('showCheckoutForm')?.classList.add('d-none');
}

                    });
                };
            });
        };
    
        refreshEventListeners();
    
        document.getElementById('showCheckoutForm')?.addEventListener('click', () => {
            document.getElementById('checkoutSection').style.display = 'block';
            document.getElementById('showCheckoutForm').style.display = 'none';
            window.scrollTo({ top: document.getElementById('checkoutSection').offsetTop - 50, behavior: 'smooth' });
        });
    
        document.getElementById('qrCheckoutFormFinal')?.addEventListener('submit', function (e) {
            e.preventDefault();
    
            const tableInput = document.getElementById('table_number');
            const tableNumber = tableInput ? tableInput.value : null;
    
            const formData = {
                customer_name: document.getElementById('customer_name').value,
                customer_phone: document.getElementById('customer_phone').value, 
                table_number: tableNumber,
                payment_method: document.querySelector('input[name="payment_method"]:checked')?.value
            };
    
            fetch("{{ route('qr.cart.checkout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Order Placed!',
                        text: 'Your order has been submitted successfully.',
                        icon: 'success',
                        confirmButtonText: 'View My Order'
                    }).then(() => {
                        localStorage.setItem('qr_order_token', data.token);
                        window.location.href = `/qr/order/${data.token}`;
                    });
                } else {
                    Swal.fire("Error", data.message || "Something went wrong!", "error");
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire("Error", "Network error occurred", "error");
            });
        });
    });
    </script>    
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const savedToken = localStorage.getItem('qr_order_token');
        if (savedToken) {
            const followUpBtn = document.createElement('a');
            followUpBtn.href = `/qr/order/${savedToken}`;
            followUpBtn.textContent = '🧾 View My Order';
            followUpBtn.className = 'btn btn-outline-success position-fixed bottom-0 end-0 m-3 shadow';
    
            document.body.appendChild(followUpBtn);
        }
    });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const orderToken = localStorage.getItem('qr_order_token');
    const viewOrderBtn = document.getElementById('viewMyOrderBtn');
    const container = document.getElementById('viewOrderContainer');

    if (orderToken && viewOrderBtn && container) {
        container.style.display = 'block';
        viewOrderBtn.href = `/qr/order/${orderToken}`;
    }
});
</script>

<script>
window.addEventListener('load', function () {
    const currentPath = window.location.pathname;

    // 🔒 لا تحذف التوكن نهائياً، فقط إذا كنت على صفحة خارج QR
    if (
        !currentPath.startsWith('/qr/')
        && !currentPath.includes('/order')
        && !currentPath.includes('/cart')
    ) {
        localStorage.removeItem('qr_order_token');
    }
});

</script>
@endsection
