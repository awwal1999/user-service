<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 15/04/2020
 * Time: 3:37 PM
 */

namespace Tests\Feature;



use App\Model\Enums\GenericStatusConstant;
use App\Model\User;
use App\RepositoryContracts\UserRepository;
use Tests\TestCase;

class UserManagementTest extends TestCase
{


    /**
     * @var UserRepository
     */
    private $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepository::class);
        $this->generateLoginToken();
    }

    public function test_get_users_param()
    {
        /**
         * This will generate 5 users!!!
         * Another extra user is generated on Login
         */


        foreach (range(0, 4) as $counter) {
            $this->createUser();
        }


        $response = $this
            ->asUser()
            ->json('GET', '/user-management/users?status=IN_ACTIVE');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'offset' => 0,
            'limit' => 20,
            'count' => 0
        ]);

    }

    public function test_get_users()
    {

        /**
         * This will generate 5 users!!!
         * Another extra user is generated on Login
         */


        foreach (range(0, 4) as $counter) {
            $this->createUser();
        }


        $response = $this
            ->asUser()
            ->json('GET', '/user-management/users');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'offset' => 0,
            'limit' => 20,
            'count' => 6
        ]);
    }

    public function test_get_user_by_identifier()
    {

        $user = $this->createUser();
        $response = $this
            ->asUser()
            ->json('GET', '/user-management/users/' . $user->identifier);


        $response->assertStatus(200);
    }


    public function test_deactivate_user()
    {
        $user = $this->createUser();
        $response = $this
            ->asUser()
            ->json('PATCH', '/user-management/users/' . $user->identifier);

        $response->assertStatus(200);
        $count = User::where('status', GenericStatusConstant::IN_ACTIVE)->count();
        $this->assertEquals(1, $count);
    }


    public function test_on_forgot_password()
    {


        $user = $this->createUser();

        $response = $this
            ->json('POST', '/forgot-password', [
                'email' => $user->email
            ]);


        $response->assertStatus(202);
    }

    public function test_that_on_forgot_password_will_fail_on_wrong_email()
    {

        $response = $this
            ->json('POST', '/forgot-password', [
                'email' => $this->faker->unique()->email
            ]);

        $response->assertStatus(422);
    }

}



