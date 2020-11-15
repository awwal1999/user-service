<?php

namespace App\Events;

use App\Model\User;

use Illuminate\Queue\SerializesModels;

class UserRegisteredEvent
{

    use SerializesModels;
    /**
     * @var User
     */
    public $user;


    /**
     * UserRegisteredEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {


        $this->user = $user;

    }


}
