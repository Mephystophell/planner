<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        //

        // Calendar definers
        Gate::define('show_calendar', function ($user) {
            return in_array($user->role_id, [1,2,3]);
        });

        // Event definers
        Gate::define('event_create', function ($user) {
            return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('event_update', function ($user) {
            return in_array($user->role_id, [1,2,3]);
        });
        Gate::define('event_delete', function ($user) {
            return in_array($user->role_id, [1,2,3]);
        });

    }
}
