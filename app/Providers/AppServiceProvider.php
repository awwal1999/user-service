<?php

namespace App\Providers;

use App\Common\Contracts\ApiKeyUtils;
use App\Common\utils\ApiKeyUtilsImpl;
use App\Contracts\Logger;
use App\Conf\StandardConsoleLoggerService;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Output\ConsoleOutput;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->singleton(Logger::class, function () {
            return new StandardConsoleLoggerService(new ConsoleOutput());
        });
        $this->app->singleton('console_log', function () {
            return $this->app->make(Logger::class);
        });

        $this->app->singleton(ApiKeyUtils::class, ApiKeyUtilsImpl::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
