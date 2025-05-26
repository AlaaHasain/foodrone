@extends('layouts.app')

@section('title', __('messages.login_to_view_orders'))

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
        <h2>{{ __('messages.login_to_view_orders') }}</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('send.otp') }}">
            @csrf

            <div class="mb-3 text-start">
                <label for="name" class="form-label">{{ __('messages.full_name') }}</label>
                <input type="text" name="name" class="form-control" required
                       pattern="^[a-zA-Z\s]{3,50}$"
                       title="Only letters and spaces allowed (3 to 50 characters)"
                       placeholder="John Doe">
            </div>

            <div class="mb-3 text-start">
                <label for="phone" class="form-label">{{ __('messages.phone_number') }}</label>
                <input type="text" name="phone" class="form-control" required
                       pattern="^[0-9+\-]{9,15}$"
                       title="Enter a valid phone number (9–15 digits)"
                       placeholder="+962791234567">
            </div>

            <div class="mb-3 text-start">
                <label for="email" class="form-label">{{ __('messages.email_address') }}</label>
                <input type="email" name="email" class="form-control" required
                       placeholder="example@email.com">
            </div>

            <div class="mb-3 text-start form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label for="remember" class="form-check-label">{{ __('messages.remember_me') }}</label>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-warning">{{ __('messages.send_otp') }}</button>

                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> {{ __('messages.back_to_home') }}
                </a>
            </div>
        </form>
    </div>
    <div id="quick-login-box" class="mt-4" style="display:none;">
    <hr>
    <p class="mb-2">{{ __('messages.already_used_device') }}</p>
    <form method="POST" action="{{ route('send.otp') }}">
        @csrf
        <input type="hidden" name="email" id="quick-email">
        <input type="hidden" name="name" id="quick-name" value="">
        <input type="hidden" name="phone" value="0000000000">
        <input type="hidden" name="remember" value="1">
        <input type="hidden" name="quick_login" value="1">
        <button type="submit" class="btn btn-warning btn-lg w-100">
            <i class="fas fa-fingerprint me-1"></i>
            {{ __('messages.login_as') }} <span id="quick-name-text"></span>
        </button>
    </form>
</div>

</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rememberedEmail = localStorage.getItem('remembered_email');
    const rememberedName  = localStorage.getItem('remembered_name');

    if (rememberedEmail && rememberedName) {
        document.getElementById('quick-login-box').style.display = 'block';
        document.getElementById('quick-email').value = rememberedEmail;
        document.getElementById('quick-name-text').textContent = rememberedName;
        document.getElementById('quick-name').value = rememberedName;
    }
});
</script>
@endsection

