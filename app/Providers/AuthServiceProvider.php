<?php

namespace App\Providers;

use App\Core\Auth\AuthGuard;
use App\Core\Auth\AuthUserProvider;
use App\Core\Auth\RequestPrincipal;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function register()
    {


        $this->app->singleton('requestPrincipal', function ($app) {
            return (new RequestPrincipal());
        });

        $this->app->bind(
            'App\Contracts\AuthService',
            'App\Core\Auth\AuthServiceImpl');
    }

    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('auth', function ($app, array $config) {
            return new AuthUserProvider(
                $app->make('App\Contracts\AuthService')
            );
        });


        Auth::extend('jwt', function ($app, $name, array $config) {
            $request = app(Request::class);
            return new AuthGuard(Auth::createUserProvider($config['provider']),
                $app->make('App\Contracts\AuthService'),
                $request);
        });

    }
}
