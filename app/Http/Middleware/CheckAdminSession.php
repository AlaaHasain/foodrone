<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin_id')) {
            session(['redirect_after_admin_login' => url()->full()]);
            return redirect()->route('admin.login')->with('error', 'You must be logged in as admin first.');
        }

        return $next($request);
    }
}
