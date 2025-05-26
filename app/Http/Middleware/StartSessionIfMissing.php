<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class StartSessionIfMissing
{
    public function handle($request, Closure $next)
    {
        // ✅ شغّل session إذا مش مفعّل
        if (!Session::isStarted()) {
            (new StartSession(app('Illuminate\Session\SessionManager')->driver()))->handle($request, function () {});
        }

        // 🔤 عيّن اللغة بناءً على الجلسة
        App::setLocale(Session::get('locale', 'en'));

        return $next($request);
    }
}
