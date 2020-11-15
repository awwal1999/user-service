<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 05/04/2020
 * Time: 7:13 AM
 */

namespace Tests\Feature;


use App\Model\Enums\GenericStatusConstant;
use App\ServiceContracts\UserManagementService;
use Tests\TestCase;

class LoginUserTest extends TestCase
{


    /**
     * @var UserManagementService
     */
    public $userManagementService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userManagementService = $this->app->make(UserManagementService::class);
    }


    public function test_a_user_can_login()
    {
        $user = $this->createUser('@123school', GenericStatusConstant::ACTIVE);


        $response = $this
            ->json('POST', '/login', [
                'username' => $user['username'],
                'password' => '@123school'
            ]);


        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);

    }

    public function test_that_a_deactivated_user_cannot_login()
    {
        $user = $this->createUser(null, '@123school');
        $this->userManagementService->deactivateUser($user->identifier);
        $response = $this
            ->json('POST', '/login', [
                'username' => $user['username'],
                'password' => '@123school'
            ]);

        $response->assertStatus(401);
    }

    public function test_a_user_from_Another_client_cannot_login()
    {
        $user = $this->createUser(null, '@123school123')->toArray();
        $response = $this
            ->json('POST', '/login', [
                'username' => $user['username'],
                'password' => '@123school123'
            ]);

        $response->assertStatus(401);


    }


}
