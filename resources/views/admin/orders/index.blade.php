
@extends('admin.layouts.app')

@section('title', 'Orders')
<style>
    .pagination {
        display: flex;
        list-style: none;
        justify-content: center;
        padding-left: 0;
        margin: 20px 0;
    }

    .pagination li {
        margin: 0 4px;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 8px 14px;
        font-size: 14px;
        color: #333;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        text-decoration: none;
        transition: 0.3s;
    }

    .pagination li.active span {
        background-color: #ffbe33;
        border-color: #ffbe33;
        color: white;
    }

    .pagination li a:hover {
        background-color: #ffbe33;
        color: white;
    }

    .pagination li.disabled span {
        color: #aaa;
        cursor: not-allowed;
        background-color: #f1f1f1;
    }
</style>

@section('content')
    <div class="header">
        <h1>Orders</h1>
    </div>

    <div class="content-section">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Total Items</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>{{ ucfirst($order->order_type) }}</td>
                        <td>{{ $order->orderItems->sum('quantity') }}</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at ? $order->created_at->format('d M Y H:i') : '' }}</td>
                        <td class="text-center align-middle">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-dark btn-sm" title="View Order">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>                                                                      
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $orders->links() }}
        </div>        
    </div>
@endsection
