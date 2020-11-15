<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Mockery;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return Application
     */

    private static $configurationApp = null;

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

//    public static function initialize()
//    {
//
//        if (is_null(self::$configurationApp)) {
//            $app = require __DIR__ . '/../bootstrap/app.php';
//
//            $app->loadEnvironmentFrom('.env.testing');
//
//            $app->make(Kernel::class)->bootstrap();
//
//            if (config('database.default') == 'sqlite') {
//                $db = app()->make('db');
//                $db->connection()->getPdo()->exec("pragma foreign_keys=1");
//            }
//
//            Artisan::call('migrate');
////            Artisan::call('db:seed');
//
//            self::$configurationApp = $app;
//            return $app;
//        }
//
//        return self::$configurationApp;
//    }

//    public function tearDown(): void
//    {
//        if ($this->app) {
//            foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
//                call_user_func($callback);
//            }
//
//        }
//
//        $this->setUpHasRun = false;
//
//        if (property_exists($this, 'serverVariables')) {
//            $this->serverVariables = [];
//        }
//
//        if (class_exists('Mockery')) {
//            Mockery::close();
//        }
//
//        $this->afterApplicationCreatedCallbacks = [];
//        $this->beforeApplicationDestroyedCallbacks = [];
//    }

}
