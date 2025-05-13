@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Edit User</h2>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>

        <div class="form-group">
            <label>Phone (Optional)</label>
            <input type="text" name="phone" value="{{ $user->phone }}">
        </div>

        <div class="form-group">
            <label>Address (Optional)</label>
            <input type="text" name="address" value="{{ $user->address }}">
        </div>

        <div class="form-actions">
            <button class="action-btn" type="submit">Update User</button>
        </div>
    </form>
</div>
@endsection