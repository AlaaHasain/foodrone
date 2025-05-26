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
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                    <th>Table</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            
            <tbody id="orders-table-body">
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            </tbody>

        </table>
        <nav>
            <ul class="pagination" id="pagination"></ul>
        </nav>     
    </div>
@endsection

<audio id="orderAlertSound" src="{{ asset('sounds/loud-alert.mp3') }}" preload="auto" loop></audio>

<script>
let oldCount = 0;
let audioPlaying = false;
let currentPage = 1;

function fetchOrders(page = 1) {
    fetch(`{{ route('admin.orders.fetch') }}?page=${page}`)
        .then(res => res.json())
        .then(data => {
            const tableBody = document.getElementById('orders-table-body');
            tableBody.innerHTML = data.html;

            const newCount = [...tableBody.querySelectorAll('tr')]
                .filter(row => row.innerHTML.includes('badge bg-warning')).length;

            if (newCount > oldCount) {
                const sound = document.getElementById('orderAlertSound');
                if (!audioPlaying) {
                    sound.play();
                    audioPlaying = true;
                }
            }

            if (newCount === 0 && audioPlaying) {
                const sound = document.getElementById('orderAlertSound');
                sound.pause();
                sound.currentTime = 0;
                audioPlaying = false;
            }

            oldCount = newCount;
            renderPagination(data.pagination);
        });
}

function renderPagination(pagination) {
    const container = document.getElementById('pagination');
    container.innerHTML = '';

    for (let i = 1; i <= pagination.last_page; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (i === pagination.current_page) li.classList.add('active');

        const a = document.createElement('a');
        a.classList.add('page-link');
        a.href = '#';
        a.textContent = i;
        a.addEventListener('click', e => {
            e.preventDefault();
            currentPage = i;
            fetchOrders(i);
        });

        li.appendChild(a);
        container.appendChild(li);
    }
}

setInterval(() => fetchOrders(currentPage), 5000);
document.addEventListener('DOMContentLoaded', () => fetchOrders(currentPage));

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('accept-btn')) {
        const orderId = e.target.dataset.id;

        fetch(`/admin/orders/${orderId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status: 'preparing' })
        })
        .then(res => res.json())
        .then(data => {
            fetchOrders(currentPage);
            const sound = document.getElementById('orderAlertSound');
            sound.pause();
            sound.currentTime = 0;
            audioPlaying = false;

            Swal.fire({
                icon: 'success',
                title: 'Order Accepted!',
                text: 'The order has been marked as preparing.',
                confirmButtonColor: '#28a745'
            });
        });
    }
});
</script>
