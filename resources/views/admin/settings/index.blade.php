@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="header">
    <h1>Settings</h1>
</div>

{{-- رسائل النجاح --}}
@if(session('success'))
    <div style="background: #d4edda; padding: 10px; margin-bottom: 20px; border-radius: 5px; color: #155724;">
        {{ session('success') }}
    </div>
@endif

@if(session('success_password'))
    <div style="background: #d1ecf1; padding: 10px; margin-bottom: 20px; border-radius: 5px; color: #0c5460;">
        {{ session('success_password') }}
    </div>
@endif

{{-- رسائل الأخطاء --}}
@if($errors->any())
    <div style="background: #f8d7da; padding: 10px; margin-bottom: 20px; border-radius: 5px; color: #721c24;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- إعدادات الموقع --}}
<div class="content-section">
    <div class="section-header">
        <h2>Website Settings</h2>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Restaurant Name</label>
            <input type="text" name="restaurant_name" value="{{ old('restaurant_name', $setting->restaurant_name) }}">
        </div>

        <div class="form-group">
            <label>Tagline</label>
            <input type="text" name="tagline" value="{{ old('tagline', $setting->tagline) }}">
        </div>

        <div class="form-group">
            <label>Current Logo</label><br>
            @if(setting('logo'))
                <img src="{{ asset('storage/' . setting('logo')) }}" alt="Logo" style="height: 70px; max-height: 70px; width: auto;">
            @else
                <span>Lemongrass</span>
            @endif
          
        </div>

        <div class="form-group">
            <label>Change Logo</label>
            <input type="file" name="logo">
        </div>

        <div class="form-group">
            <label>Currency</label>
            <select name="currency">
                <option value="USD" {{ old('currency', $setting->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                <option value="JOD" {{ old('currency', $setting->currency) == 'JOD' ? 'selected' : '' }}>JOD (د.أ)</option>
                <option value="EUR" {{ old('currency', $setting->currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                <option value="GBP" {{ old('currency', $setting->currency) == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Timezone</label>
            <select name="timezone">
                <option value="UTC" {{ old('timezone', $setting->timezone) == 'UTC' ? 'selected' : '' }}>UTC</option>
                <option value="Asia/Amman" {{ old('timezone', $setting->timezone) == 'Asia/Amman' ? 'selected' : '' }}>Asia/Amman (GMT+3)</option>
                <option value="Asia/Riyadh" {{ old('timezone', $setting->timezone) == 'Asia/Riyadh' ? 'selected' : '' }}>Asia/Riyadh (GMT+3)</option>
                <option value="America/New_York" {{ old('timezone', $setting->timezone) == 'America/New_York' ? 'selected' : '' }}>America/New York (GMT-5)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Admin Email</label>
            <input type="email" name="admin_email" value="{{ old('admin_email', $setting->admin_email) }}">
        </div>

        <div class="form-actions">
            <button type="submit" class="action-btn">Save Changes</button>
        </div>
    </form>
</div>

{{-- تغيير كلمة المرور --}}
<div class="content-section">
    <div class="section-header">
        <h2>Change Password</h2>
    </div>

    <form action="{{ route('admin.settings.change-password') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password">
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation">
        </div>

        <div class="form-actions">
            <button type="submit" class="action-btn">Change Password</button>
        </div>
    </form>
</div>
@endsection
