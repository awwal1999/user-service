<?php

namespace App\Listeners;

use App\Contracts\AuthService;
use App\Events\PasswordResetEvent;
use App\Facade\Console;
use App\ServiceContracts\UserManagementService;
use http\Client\Curl\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPasswordResetEmail
{
    /**
     * @var UserManagementService
     */
    private $userManagementService;


    /**
     * SendPasswordResetEmail constructor.
     * @param UserManagementService $userManagementService
     */
    public function __construct(UserManagementService $userManagementService)
    {

        $this->userManagementService = $userManagementService;
    }


    /**
     * @param PasswordResetEvent $event
     */
    public function handle(PasswordResetEvent $event)
    {

        $refreshToken = $this->userManagementService->generateUserRefreshToken($event->getUser());
        // Fresh token is published to a message broker.
    }
}
