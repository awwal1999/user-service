<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 06/04/2020
 * Time: 1:07 AM
 */

namespace Tests\Feature;


use Tests\TestCase;

class MeTest extends TestCase
{


    public function setUp(): void
    {
        parent::setUp();
        $this->generateLoginToken();
    }


    public function test_a_user_can_get_is_details()
    {

        $response = $this->asUser()
            ->json('GET', 'auth/me');


        $response->assertStatus(200);

    }

    public function test_that_user_information_can_be_gotten_with_valid_response()
    {
        $response = $this->asUser()
            ->json('GET', 'auth/me');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'firstName',
                    'lastName',
                    'username',
                    'middleName',
                    'email',
                    'gender',
                    'nin',
                    'bvn',
                    'mothersMaidenName',
                ],
                'memberships' => [
                    [
                        'account' => [
                            'name',
                            'code'
                        ],
                        'roles' => [

                        ]
                    ]
                ]
            ]
        ]);
    }
}
