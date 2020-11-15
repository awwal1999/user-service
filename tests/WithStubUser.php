<?php


namespace Tests;


use App\Contracts\AuthService;
use App\Model\Enums\GenericStatusConstant;
use App\Model\User;
use App\ServiceContracts\UserManagementService;
use Faker\Generator;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

trait WithStubUser
{


    public $loginToken;


    /**
     * @var AuthService
     */
    public $authService;

    /**
     * @var Generator
     */
    public $faker;
    /**
     * @var UserManagementService
     */
    public $userManagementService;


    public function generateLoginToken()
    {

        $user = $this->createUser();

        $this->loginToken = $this->authService->issueAuthToken($user);
    }


    /**
     * @return MakesHttpRequests
     */
    public function asUser()
    {


        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->loginToken
        ]);
    }


    /**
     * @param string|null $password
     * @param string $status
     * @return User
     */
    public function createUser(string $password = null, $status = GenericStatusConstant::ACTIVE): User
    {

        $user = factory(User::class)
            ->make([
                'status' => $status
            ])
            ->toArray();
        if (is_null($password)) {
            $user['password'] = $this->faker->password;
        } else {
            $user['password'] = $password;
        }


        $user['validateEmail'] = false;
        $user['dob'] = '1992-10-02';
        return $this->userManagementService->createUser($user);

    }
}
