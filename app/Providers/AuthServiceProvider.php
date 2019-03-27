<?php

namespace App\Providers;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(/*GateContract $gate*/)
    {
        $this->registerPolicies();
        Gate::define('isAdmin', function ($user) {
            return $user->type == 'admin';
        });

        Gate::define('isVendor', function ($user) {
            return $user->type == 'vendor';
        });
        Gate::define('isAdminOrVendor', function ($user) {
            if($user->type == 'vendor'||$user->type == 'admin')
            return true;
        });
        Gate::define('isMyAccount', function ($user,$profileUser) {
            return $user->id == $profileUser->id;
        });

        Passport::routes();

        //
    }
}
