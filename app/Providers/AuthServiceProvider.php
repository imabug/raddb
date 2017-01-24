<?php

namespace RadDB\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'RadDB\Model' => 'RadDB\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        // Authorization gates
        $gate->define('create-machine', function ($user) {
            return $user->is_admin;
        });
        $gate->define('create-survey', function ($user) {
            return $user->is_admin;
        });
        $gate->define('add-surveyreport', function ($user) {
            return $user->is_admin;
        });
        $gate->define('add-servicereport', function ($user) {
            return $user->is_admin;
        });
        $gate->define('create-recommendation', function ($user) {
            return $user->is_admin;
        });
    }
}
