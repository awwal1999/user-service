<?php

namespace App\Rules;

use App\Facade\Console;
use App\Facade\RequestPrincipal;
use App\RepositoryContracts\UserRepository;
use Illuminate\Contracts\Validation\Rule;

class UserInfoRule implements Rule
{


    /**
     * @var UserRepository
     */

    private $userRepository;


    /**
     * UserInfo constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;


    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool
     */
    public function passes($attribute, $value, $parameters = [])
    {

        $findAttribute = 'id';
        $exists = false;
        if (!empty($parameters)) {
            $findAttribute = $parameters[0];
        }
        if (sizeof($parameters) == 2 && (strcasecmp($parameters[1], 'exist') == 0)) {
            $exists = true;
        }
        $count = $this->userRepository->countByProvidedUserAttribute($findAttribute, $value);

        if ($count && $exists) return true;
        if (!$count && !$exists) return true;

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '';
    }
}
