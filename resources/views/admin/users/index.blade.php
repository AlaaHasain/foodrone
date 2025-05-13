@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Users</h2>
        <a href="{{ route('admin.users.create') }}" class="action-btn">Add User</a>
    </div>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <div style="margin-bottom: 20px;">
        <form action="{{ route('admin.users.index') }}" method="GET" style="display: inline-block; margin-right: 20px;">
            <select name="role" onchange="this.form.submit()" style="padding: 8px; border-radius: 5px;">
                <option value="">All Roles</option>
                <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </form>
    
        <div style="display: inline-block;">
            <span>Super Admins: {{ $rolesCount['super_admin'] }}</span> |
            <span>Admins: {{ $rolesCount['admin'] }}</span> |
            <span>Staff: {{ $rolesCount['staff'] }}</span> |
            <span>Customers: {{ $rolesCount['customer'] }}</span>
        </div>
    </div>
    
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td>{{ $user->address ?? '-' }}</td>
                <td class="text-center">
                    {{-- Edit Icon --}}
                    <a href="{{ route('admin.users.edit', $user) }}" style="color: #2bbbad; font-size: 18px; margin-right: 8px;">
                        <i class="fas fa-pen-to-square"></i>
                    </a>
                
                    {{-- Delete Icon --}}
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; padding: 0; color: #ee5253; font-size: 18px; cursor: pointer;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection