@extends('layouts.app')

@section('title', __('messages.verify_otp'))


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

    .verify-wrapper .form-label {
        font-weight: 600;
    }

    .verify-wrapper .form-control {
        border-radius: 12px;
        height: 50px;
        font-size: 16px;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 50px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .timer {
        margin-top: 6px;
        font-size: 13px;
        color: #dc3545;
        font-weight: 500;
        text-align: left;
    }

    .resend-btn {
        background-color: transparent;
        border: none;
        color: #007bff;
        cursor: pointer;
        font-size: 14px;
        padding: 8px 16px;
        margin-top: 8px;
        text-align: center;
        border-radius: 50px;
        border: 1px solid #007bff;
        width: 100%;
        transition: all 0.3s ease;
    }

    .resend-btn:hover:not(:disabled) {
        background-color: #007bff;
        color: #ffffff;
    }

    .resend-btn:disabled {
        color: #6c757d;
        border-color: #6c757d;
        cursor: not-allowed;
    }

    .text-start {
        text-align: left !important;
    }
</style>

<div class="container py-5">
    <div class="verify-wrapper">
        <h2>{{ __('messages.verify_otp') }}</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('verify.otp') }}">
            @csrf

            <p class="mb-4">{{ __('messages.code_sent_to') }} <strong>{{ session('otp_email') }}</strong></p>

            <div class="mb-3 text-start">
                <label for="otp" class="form-label">{{ __('messages.otp_code') }}</label>
                <input type="text" name="otp"
                       id="otp"
                       value="{{ old('otp') }}"
                       class="form-control @error('otp') is-invalid @enderror"
                       placeholder="{{ __('messages.enter_otp_placeholder') }}" required>
                @error('otp')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <div class="timer" id="timer">{{ __('messages.time_remaining') }} <span id="countdown">60</span> {{ __('messages.seconds') }}</div>
            </div>

            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-success" id="verifyBtn">✓ {{ __('messages.verify') }}</button>
            </div>
        </form>

        <div class="d-grid gap-2 mt-3">
            <form method="POST" action="{{ route('resend.otp') }}" id="resend-form">
                @csrf
                <button type="submit" class="resend-btn" id="resendBtn" disabled>
                    {{ __('messages.resend_verification_code') }}
                </button>
            </form>
        </div>

        <div class="mt-3">
            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> {{ __('messages.back_to_login') }}
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let secondsLeft = 30;
    const countdown = document.getElementById('countdown');
    const timerDiv = document.getElementById('timer');
    const resendBtn = document.getElementById('resendBtn');
    const resendForm = document.getElementById('resend-form');
    const verifyBtn = document.getElementById('verifyBtn');

    resendBtn.style.display = 'block';
    resendBtn.disabled = true;

    // ✅ عرض الرقم 30 مباشرة
    countdown.textContent = secondsLeft;

    let interval = setInterval(updateTimer, 1000);

    function updateTimer() {
        secondsLeft--;
        countdown.textContent = secondsLeft;

        if (secondsLeft <= 0) {
            clearInterval(interval);
            timerDiv.textContent = 'Time expired! You can request a new code.';
            resendBtn.disabled = false;
            verifyBtn.disabled = true;
        }
    }

    resendForm.addEventListener('submit', function (e) {
        e.preventDefault();
        resendBtn.disabled = true;
        resendBtn.textContent = 'Sending...';

        fetch(resendForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            resendBtn.textContent = 'Resend verification code';
            verifyBtn.disabled = false;

            // ✅ إعادة ضبط العداد
            secondsLeft = 30;
            timerDiv.innerHTML = 'Time remaining: <span id="countdown">30</span> seconds';
            resendBtn.disabled = true;
            countdown.textContent = secondsLeft;

            clearInterval(interval);
            interval = setInterval(updateTimer, 1000);

            // ✅ SweetAlert بدلاً من alert
            Swal.fire({
                icon: 'success',
                title: 'OTP Sent!',
                text: data.message || 'A new verification code has been sent to your email.',
                confirmButtonColor: '#28a745',
            });
        })
        .catch(() => {
            resendBtn.textContent = 'Resend verification code';
            resendBtn.disabled = false;

            Swal.fire({
                icon: 'error',
                title: 'Failed!',
                text: 'Could not resend OTP. Please try again.',
                confirmButtonColor: '#dc3545',
            });
        });
    });

    document.getElementById('otp').focus();
});
</script>

@endsection