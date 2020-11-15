<?php

namespace App\Events;

use App\Model\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEvent
{
    use Dispatchable, SerializesModels;


    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


}
