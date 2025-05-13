@extends('admin.layouts.app')

@section('title', 'Reservation Details')

@section('content')
    <div class="header">
        <h1>Reservation #{{ $reservation->id }}</h1>
    </div>

    <div class="content-section">
        <h3>Customer Information</h3>
        <p><strong>Name:</strong> {{ $reservation->customer_name }}</p>
        <p><strong>Contact Number:</strong> {{ $reservation->contact_number }}</p>
        <p><strong>Number of People:</strong> {{ $reservation->people }}</p>
        <p><strong>Date:</strong> {{ $reservation->date }}</p>
        <p><strong>Time:</strong> {{ $reservation->time }}</p>
        <p><strong>Status:</strong> {{ ucfirst($reservation->status) }}</p>

        <hr>

        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" style="margin-top: 20px;">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Update Status:</label>
                <select name="status" required>
                    <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.reservations.index') }}" class="secondary-btn">Back</a>
                <button type="submit" class="action-btn">Update Status</button>
            </div>
        </form>
    </div>
@endsection
