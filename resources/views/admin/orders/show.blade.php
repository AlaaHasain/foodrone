<style>

/* Admin Order Details Styles */
@import url('https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap');

/* General Styles */
body {
    font-family: 'Rubik', sans-serif;
    background-color: #f5f7fa;
    color: #333;
    line-height: 1.6;
}

/* Header Styles */
.header {
    background-color: #fff;
    padding: 20px 30px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
    border-radius: 4px;
}

.header h1 {
    color: #2c3e50;
    margin: 0;
    font-weight: 600;
    font-size: 1.8rem;
}

/* Content Section */
.content-section {
    background-color: #fff;
    padding: 30px;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
}

/* Typography */
h3 {
    color: #2c3e50;
    font-weight: 600;
    margin-top: 0;
    margin-bottom: 20px;
    border-bottom: 2px solid #f1f1f1;
    padding-bottom: 10px;
    font-size: 1.3rem;
}

p {
    margin-bottom: 12px;
}

strong {
    font-weight: 600;
    color: #2c3e50;
}

hr {
    border: none;
    border-top: 1px solid #eaedf0;
    margin: 25px 0;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

table th {
    background-color: #f8f9fa;
    color: #2c3e50;
    font-weight: 600;
    text-align: left;
    padding: 12px 15px;
    border-bottom: 2px solid #eaedf0;
}

table td {
    padding: 12px 15px;
    border-bottom: 1px solid #eaedf0;
}

table tbody tr:hover {
    background-color: #f8fafd;
}

/* Form Styles */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #2c3e50;
}

select {
    width: 100%;
    max-width: 300px;
    padding: 10px 12px;
    border: 1px solid #dce0e5;
    border-radius: 4px;
    font-family: inherit;
    background-color: white;
    font-size: 14px;
    color: #333;
}

select:focus {
    outline: none;
    border-color: #5e72e4;
    box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.1);
}

/* Button Styles */
.form-actions {
    margin-top: 25px;
    display: flex;
    gap: 15px;
}

.action-btn {
    background-color: #5e72e4;
    color: white;
    border: none;
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
    font-size: 14px;
}

.action-btn:hover {
    background-color: #4c60ce;
}

.secondary-btn {
    background-color: #eaedf0;
    color: #5a6878;
    border: none;
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
    text-decoration: none;
    font-size: 14px;
}

.secondary-btn:hover {
    background-color: #dce0e5;
}

/* For print media */
@media print {
    .form-actions {
        display: none;
    }
    
    body {
        background-color: white;
    }
    
    .content-section, .header {
        box-shadow: none;
        padding: 0;
    }
}

/* RTL Support for Arabic */
[dir="rtl"] body {
    text-align: right;
}

[dir="rtl"] .form-actions {
    flex-direction: row-reverse;
}

[dir="rtl"] table th {
    text-align: right;
}

</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="header">
        <h1>Order #{{ $order->id }}</h1>
    </div>

    <div class="content-section">

        <h3>Customer Information</h3>
        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        @if($order->order_type == 'delivery')
            <p><strong>Address:</strong> {{ $order->customer_address }}</p>
        @endif
        <p><strong>Order Type:</strong> {{ ucfirst($order->order_type) }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Notes:</strong> {{ $order->notes ?? 'No notes' }}</p>
        @if($order->pickup_time)
            <p><strong>Pickup/Delivery Time:</strong> {{ $order->pickup_time }}</p>
        @endif

        <hr>

        <h3>Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Dish</th>
                    <th>Quantity</th>
                    <th>Price (each)</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->menuItem->name ?? 'Deleted Item' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->price }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 style="margin-top: 20px;">Total Amount: $
            {{
                number_format(
                    $order->orderItems->sum(function($item) {
                        return $item->price * $item->quantity;
                    }),
                    2
                )
            }}
        </h3>

        <hr>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="margin-top: 20px;">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Update Status:</label>
                <select name="status" required>
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.orders.index') }}" class="secondary-btn">Back</a>
                <button type="submit" class="action-btn">Update Status</button>
            </div>          
        </form>
        <!-- ✅ زر إرسال PDF منفصل -->
<form action="{{ route('admin.orders.sendPdf', $order->id) }}" method="POST" style="margin-top: 10px;">
    @csrf
    <button type="submit" class="action-btn" style="background-color:#ffc107;">Send PDF to Customer</button>
</form>
    </div>
@endsection
@if(session('pdf_sent'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('pdf_sent') }}',
        confirmButtonColor: '#5e72e4'
    });
</script>
@endif

@if(session('pdf_error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('pdf_error') }}',
        confirmButtonColor: '#d33'
    });
</script>
@endif
