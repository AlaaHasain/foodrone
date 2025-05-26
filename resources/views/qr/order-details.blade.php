@extends('layouts.app')

@section('title', 'My QR Order')

@section('content')
<div class="container py-5">
    <h2 class="text-center text-success mb-4">🧾 Your Order</h2>

    {{-- ✅ معلومات الزبون --}}
    <div class="mb-4">
        <h4><strong>Name:</strong> {{ $order->customer_name }}</h4>
        <h5><strong>Phone:</strong> {{ $order->customer_phone ?? '-' }}</h5>
        <h5><strong>Table:</strong> {{ $order->table_number ?? '-' }}</h5>
        <h5><strong>Status:</strong>
            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                {{ ucfirst($order->status) }}
            </span>
        </h5>
    </div>

    <hr>

    @php
    $subtotal = $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
    $taxRate = \App\Models\Setting::first()?->order_tax_rate ?? 0;
    $taxAmount = round($subtotal * ($taxRate / 100), 2);
    $totalWithTax = $subtotal + $taxAmount;
@endphp

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Dish</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->menuItem->name ?? 'Deleted Item' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- ✅ ملخص الطلب --}}
<div class="text-end mt-4">
    <p class="mb-1 fw-bold">Subtotal: ${{ number_format($subtotal, 2) }}</p>
    <p class="mb-1 fw-bold">Tax ({{ $taxRate }}%): ${{ number_format($taxAmount, 2) }}</p>
    <h4 class="mt-2 fw-bold text-success">Total (incl. tax): ${{ number_format($totalWithTax, 2) }}</h4>
</div>
<div class="text-center mt-4">
<a href="{{ route('menu.qr.view', ['token' => session('qr_token')]) }}" class="btn btn-outline-dark btn-lg">
    ← Back to Menu
</a>

</div>

@endsection
