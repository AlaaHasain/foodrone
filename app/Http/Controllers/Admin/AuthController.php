<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $credentials['email'])->first();

    if (!$user || !in_array($user->role, ['staff','admin', 'super_admin'])) {
        return back()->withErrors(['email' => 'You do not have permission to access the dashboard.']);
    }

    if (!\Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // ✅ تخزين بيانات الدخول في الجلسة
    session([
        'admin_id'   => $user->id,
        'admin_name' => $user->name,
        'admin_role' => $user->role,
    ]);

    return redirect()->route('admin.dashboard');
}

}
