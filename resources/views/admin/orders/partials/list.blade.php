<style>
.accept-btn {
    background-color: #28a745;
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 30px;
    padding: 6px 20px;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: background-color 0.3s ease, transform 0.2s ease;
    margin-right: 8px;
}

.accept-btn:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.accept-btn:active {
    background-color: #1e7e34;
    transform: scale(0.98);
}

.view-btn {
    background-color: #ffbe33;
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 30px;
    padding: 6px 20px;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: background-color 0.3s ease, transform 0.2s ease;
    text-decoration: none;
    display: inline-block;
}

.view-btn:hover {
    background-color: #e0a800;
    transform: scale(1.05);
}

.view-btn:active {
    background-color: #c69500;
    transform: scale(0.98);
}
</style>

@foreach($orders as $order)
<tr>
    <td>{{ $order->id }}</td>
    <td>{{ $order->customer_name }}</td>
    <td>{{ $order->customer_email ?? '-' }}</td>
    <td>
        @if($order->order_type === 'dine_in')
            {{ $order->table_number }}
            @if($order->table_conflict && $order->status !== 'completed')
                <span style="color: red; font-weight: bold;" title="Conflict: another order on this table">⚠</span>
            @endif
        @else
            -
        @endif
    </td>
    <td>{{ ucfirst($order->order_type) }}</td>
    <td>
        <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : 'success' }}">
            {{ ucfirst($order->status) }}
        </span>
    </td>
    <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
    <td>
        @if($order->status === 'pending')
            <button 
                class="accept-btn"
                data-id="{{ $order->id }}"
                data-view-url="{{ route('admin.orders.show', $order->id) }}"
            >
                Accept
            </button>
        @else
            <a href="{{ route('admin.orders.show', $order->id) }}" class="view-btn">
                View
            </a>
        @endif
    </td>
</tr>
@endforeach
