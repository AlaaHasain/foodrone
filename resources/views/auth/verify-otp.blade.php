@extends('layouts.app')

@section('title', 'Verify OTP')

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
    }

    .verify-wrapper .form-control {
        border-radius: 12px;
        height: 50px;
        font-size: 16px;
    }

    .verify-wrapper .btn-success {
        background-color: #28a745;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 50px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .verify-wrapper .btn-success:hover {
        background-color: #218838;
    }
</style>

<div class="container py-5">
    <div class="verify-wrapper">
        <h2>Verify Your OTP</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('verify.otp') }}">
            @csrf

            <p class="mb-4">Code sent to: <strong>{{ session('otp_email') }}</strong></p>

            <div class="mb-3 text-start">
                <label for="otp" class="form-label">OTP Code</label>
                <input type="text" name="otp" class="form-control" placeholder="Enter 6-digit code" required>
            </div>

            <button type="submit" class="btn btn-success">Verify</button>
        </form>
    </div>
</div>
@endsection
