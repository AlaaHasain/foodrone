<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCustomerLogin
{
// CheckCustomerLogin.php
public function handle($request, Closure $next)
{
    if (!session()->has('customer_id')) {
        session(['redirect_after_login' => url()->full()]);
        return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً.');
    }

    return $next($request);
}

}