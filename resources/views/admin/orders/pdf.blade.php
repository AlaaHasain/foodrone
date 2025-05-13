<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            color: #333;
            padding: 40px;
        }

        .invoice-header {
            text-align: center;
            border-bottom: 2px solid #ffbe33;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .invoice-header img {
            max-height: 60px;
            margin-bottom: 10px;
        }

        .invoice-header h1 {
            margin: 0;
            color: #ffbe33;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .order-info {
            margin-bottom: 30px;
        }

        .order-info p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #ffe08a;
            color: #222;
            text-align: left;
            padding: 12px;
            font-weight: bold;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
            border-top: 2px solid #ffbe33;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }

        .footer-note {
            margin-top: 40px;
            font-size: 13px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="invoice-header">
        {{-- لوجو المطعم (اختياري) --}}
        <img src="{{ public_path('images/logo.png') }}" alt="LEMONGRASS Logo">
        <h1>LEMONGRASS</h1>
        <p><em>Asian Fusion Cuisine</em></p>
    </div>

    <div class="order-info">
        <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email ?? '-' }}</p>
        <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
        @if($order->customer_address)
            <p><strong>Address:</strong> {{ $order->customer_address }}</p>
        @endif
        <p><strong>Order Type:</strong> {{ ucfirst($order->order_type) }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Dish</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($order->orderItems as $item)
                @php 
                    $subtotal = $item->price * $item->quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $item->menuItem->name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Grand Total</td>
                <td>${{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <p class="footer-note">Thank you for choosing <strong>LEMONGRASS</strong>! We appreciate your order.</p>

</body>
</html>
