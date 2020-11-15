<?php

namespace App\Providers;

use App\Events\PasswordResetEvent;
use App\Events\UserRegisteredEvent;
use App\Listeners\SendPasswordResetEmail;
use App\Listeners\SendUserVerificationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserRegisteredEvent::class => [
            SendUserVerificationNotification::class
        ],
        PasswordResetEvent::class => [
            SendPasswordResetEmail::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

        parent::boot();
        if (env('SHOW_SQL', false)) {
            DB::listen(function ($query) {
                $loggingConsole = new ConsoleOutput();
                $loggingConsole->writeln(sprintf("%s, %s, [%s]", $query->time, $query->sql, implode(",", $query->bindings)));
                Log::info(sprintf("%s, %s, [%s]", $query->time, $query->sql, implode(",", $query->bindings)));
        });

    }


//    public function shouldDiscoverEvents()
//    {
//        return true;
//    }


}
