@section('title', 'My QR Order')

@section('content')
<div class="container py-5">
    <h2 class="text-center text-success mb-4">🧾 Your Order</h2>

    <h4>Name: {{ $order->customer_name }}</h4>
    <h5>Table: {{ $order->table_number }}</h5>
    <h5>Status: <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">{{ ucfirst($order->status) }}</span></h5>

    <hr>

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

    <div class="text-end fw-bold h5">
        Total: ${{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 2) }}
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ route('menu.qr.view', ['token' => $order->token]) }}" class="btn btn-outline-dark btn-lg">
            ← Back to Menu
        </a>
    </div>    
</div>
@endsection

@extends('layouts.app')

