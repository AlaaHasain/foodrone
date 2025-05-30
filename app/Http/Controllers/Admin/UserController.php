<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUser;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        $rolesCount = [
            'super_admin' => User::where('role', 'super_admin')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'customer' => User::where('role', 'customer')->count(),
        ];

        return view('admin.users.index', compact('users', 'rolesCount'));
    }


    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'role' => 'required|in:super_admin,admin,staff,customer',
    'phone' => 'nullable|string|max:20',
    'address' => 'nullable|string|max:255',
    'password' => 'required|string|min:6|confirmed', // ← ضروري
]);

$validated['password'] = Hash::make($request->password);

$user = User::create($validated);

return redirect()->route('admin.users.index')->with('success', "User created successfully.");

    }
    

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,admin,staff,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}