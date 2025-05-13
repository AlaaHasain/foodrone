<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // يسمح فقط للـ super_admin بإدارة المستخدمين
        Gate::define('manage-users', function ($user) {
            return $user->role === 'super_admin';
        });

        // يسمح للـ admin و super_admin بإدارة المينيو والعناصر الأخرى
        Gate::define('manage-menu', function ($user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        // يسمح للـ staff و admin و super_admin بعرض الطلبات وتحديثها
        Gate::define('view-orders', function ($user) {
            return in_array($user->role, ['staff', 'admin', 'super_admin']);
        });

        // بوابة عامة يمكن استخدامها لأي صلاحية كاملة
        Gate::define('full-access', function ($user) {
            return $user->role === 'super_admin';
        });
    }
}
