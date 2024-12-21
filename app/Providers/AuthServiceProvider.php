<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('super-admin', function($user){
            return $user->role->name == "Super Admin";
        });
        
        Gate::define('only-contractor', function($user){
            return $user->role->name == "Contractor";
        });

        Gate::define('contractor', function($user){
            return $user->role->name == "Super Admin" || $user->role->name == "Contractor";
        });
    }
}
