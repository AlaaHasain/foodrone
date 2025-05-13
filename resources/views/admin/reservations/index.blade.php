<style>
    .btn-sm {
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 6px;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
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

@extends('admin.layouts.app')

@section('title', 'Reservations')

@section('content')
    <div class="header">
        <h1>Reservations</h1>
    </div>

    <div class="content-section">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>People</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $index => $reservation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $reservation->customer_name }}</td>
                        <td>{{ $reservation->contact_number }}</td>
                        <td>{{ $reservation->people }}</td>
                        <td>{{ $reservation->date }}</td>
                        <td>{{ $reservation->time }}</td>
                        <td>
                            @if($reservation->status == 'pending')
                                <span class="badge" style="background-color: #17a2b8; color: white;">Pending</span> <!-- أزرق -->
                            @else
                                <span class="badge" style="background-color: #6f42c1; color: white;">Accepted</span> <!-- بنفسجي -->
                            @endif
                        </td>
                        <td>
                            @if($reservation->status == 'pending')
                                <form action="{{ route('admin.reservations.accept', $reservation->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Accept</button>
                                </form>
                            @endif
        
                            <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $reservations->links() }}
        </div>        
    </div>
@endsection