@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">

    {{-- ✅ العنوان مع اسم المستخدم والأيقونة --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-user-circle me-2 text-warning"></i>
            {{ ucfirst($user->name ?? 'Guest') }}'s Orders
        </h2>
    </div>

    {{-- ✅ فلترة حسب نوع الطلب بألوان متناسقة --}}
    <div class="mb-4 text-center">
        <a href="{{ route('my_orders') }}"
           class="btn {{ !request('type') ? 'btn-warning text-white' : 'btn-outline-secondary' }} mx-2 rounded-pill">
            All
        </a>
        <a href="{{ route('my_orders', ['type' => 'pickup']) }}"
           class="btn {{ request('type') == 'pickup' ? 'btn-warning text-white' : 'btn-outline-secondary' }} mx-2 rounded-pill">
            Pick Up
        </a>
        <a href="{{ route('my_orders', ['type' => 'delivery']) }}"
           class="btn {{ request('type') == 'delivery' ? 'btn-warning text-white' : 'btn-outline-secondary' }} mx-2 rounded-pill">
            Delivery
        </a>
    </div>

    {{-- ✅ زر تسجيل الخروج --}}
    <div class="text-end mb-4">
        <a href="{{ route('logout') }}" class="btn btn-outline-danger rounded-pill px-4">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>

    {{-- ✅ عرض الطلبات --}}
    @if ($orders->isEmpty())
        <div class="alert alert-info text-center">You have no orders yet.</div>
    @else
        @foreach ($orders as $order)
        <div class="card shadow-sm mb-4 rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h5 class="mb-0">Order #{{ $order->id }}</h5>
                    <span class="badge bg-{{ $order->status === 'accepted' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>

                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Type:</strong> {{ ucfirst($order->order_type) }}</p>
                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($order->pickup_time)->format('h:i A') }}</p>

                @if($order->customer_address)
                    <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                @endif
                @if($order->notes)
                    <p><strong>Notes:</strong> {{ $order->notes }}</p>
                @endif

                <div class="table-responsive mt-3">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Dish</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($order->orderItems as $item)
                                @php 
                                    $subtotal = $item->price * $item->quantity;
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ optional($item->menuItem)->name ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>${{ number_format($total, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
