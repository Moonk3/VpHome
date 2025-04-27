<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('modules', function($user, $permisionName){
            // Kiểm tra nếu user không phải admin, hoặc không có catalogue
            if (!$user || !$user->user_catalogues || $user->publish == 0) {
                return false; // Khách hàng không có quyền
            }

            // Nếu người dùng có quyền truy cập, kiểm tra permissions
            $permission = $user->user_catalogues->permissions;
            if ($permission && $permission->contains('canonical', $permisionName)) {
                return true; // Người dùng có quyền
            }

            return false; // Không có quyền
        });
    }
}
