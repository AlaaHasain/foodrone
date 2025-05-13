@extends('layouts.app')

@section('title', 'Login to View Orders')

@section('content')
<style>
    .verify-wrapper {
        max-width: 500px;
        margin: auto;
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .verify-wrapper h2 {
        font-weight: 700;
        color: #333;
        margin-bottom: 24px;
    }

    .verify-wrapper p {
        font-size: 15px;
        color: #666;
    }

    .verify-wrapper .form-label {
        font-weight: 600;
        text-align: left;
        display: block;
    }

    .verify-wrapper .form-control {
        border-radius: 12px;
        height: 50px;
        font-size: 16px;
    }

    .verify-wrapper .btn-warning {
        background-color: #ffc107;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 50px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .verify-wrapper .btn-warning:hover {
        background-color: #e0a800;
    }
</style>

<div class="container py-5">
    <div class="verify-wrapper">
        <h2>Login to View Orders</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('send.otp') }}">
            @csrf

            <div class="mb-3 text-start">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required
                       pattern="^[a-zA-Z\s]{3,50}$"
                       title="Only letters and spaces allowed (3 to 50 characters)"
                       placeholder="John Doe">
            </div>

            <div class="mb-3 text-start">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required
                       pattern="^[0-9+\-]{9,15}$"
                       title="Enter a valid phone number (9–15 digits)"
                       placeholder="+962791234567">
            </div>

            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required
                       placeholder="example@email.com">
            </div>

            <button type="submit" class="btn btn-warning">Send OTP</button>
        </form>
    </div>
</div>
@endsection
