<?php

namespace Tests\Feature;

use App\Model\PortalAccountType;
use App\Model\User;
use App\RepositoryContracts\UserRepository;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_be_created()
    {


        $user = factory(User::class)->make();
        $newUser = $user->toArray();
        $newUser['password'] = $this->faker->password;
        $response = $this
            ->json('POST', '/signup', $newUser);


        unset($newUser['password']);

        $response->assertStatus(201);

    }

    public function test_that_same_user_cannot_be_created_on_same_client()
    {

        $user = $this->createUser();

        $response = $this
            ->json('POST', '/signup', $user->toArray());

        $response->assertStatus(422);

    }




    public function test_that_validation_works_on_request()
    {
        $user = factory(User::class)->make();
        $newUser = $user->toArray();
        $response = $this
            ->json('POST', '/signup', $newUser);

        $response->assertStatus(422);
    }

    public function test_that_a_user_can_be_created_with_account_type_code()
    {
        $user = factory(User::class)->make();
        $portalAccountType = factory(PortalAccountType::class)->create();
        $newUser = $user->toArray();
        $newUser['password'] = $this->faker->password;
        $newUser['portalAccountTypeCode'] = $portalAccountType->code;

        $response = $this
            ->json('POST', '/signup', $newUser);


        $response->assertStatus(201);
        $userRepository = $this->app->make(UserRepository::class);
        $createdUser = $userRepository->getUserByUsernameInApp($newUser['username']);

        $this->assertEquals($portalAccountType->id, $createdUser->portalAccounts->toArray()[0]['type_id']);

    }

    public function test_that_a_user_cannot_be_created_with_the_wrong_account_type_code()
    {
        $user = factory(User::class)->make();
        $portalAccountType = factory(PortalAccountType::class)->make();
        $newUser = $user->toArray();
        $newUser['password'] = $this->faker->password;
        $newUser['portalAccountTypeCode'] = $portalAccountType->code;

        $response = $this
            ->json('POST', '/signup', $newUser);

        $response->assertStatus(422);

    }




}
