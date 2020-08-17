<?php

namespace App\Providers;

use App\Http\Controllers\TokenController;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        if(!TokenController::isAuthorized()) {
            abort(403, "Militar não autorizado.");
        }

        $this->registerPolicies();

        //
    }
}
