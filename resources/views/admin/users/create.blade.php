@extends('admin.layouts.app')

@section('title', 'Add User')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Add New User</h2>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="super_admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
                <option value="customer">Customer</option>
            </select>
        </div>

        <div class="form-group">
            <label>Phone (Optional)</label>
            <input type="text" name="phone">
        </div>

        <div class="form-group">
            <label>Address (Optional)</label>
            <input type="text" name="address">
        </div>

        <div class="form-actions">
            <button class="action-btn" type="submit">Add User</button>
        </div>
    </form>
</div>
@endsection