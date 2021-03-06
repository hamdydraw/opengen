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

        Gate::define('isMerchant', function ($user) {
            return $user->type == 'merchant';
        });
        Gate::define('isEU', function ($user) {
            return $user->type == 'enduser';
        });
        Gate::define('isDMM', function ($user) {
            return $user->type == 'dmm';
        });
        Gate::define('isPilot', function ($user) {
            return $user->type == 'pilot';
        });
        Gate::define('isAdminOrMerchant', function ($user) {
            if($user->type == 'merchant'||$user->type == 'admin')
            return true;
        });
        Gate::define('isMyAccount', function ($user,$profileUser) {
            return $user->id == $profileUser->id;
        });

        Passport::routes();

        //
    }
}
