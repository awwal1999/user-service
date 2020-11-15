<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 07/04/2020
 * Time: 11:18 AM
 */

namespace Tests\Feature;


use App\Model\Enums\GenericStatusConstant;
use App\Model\Membership;
use App\Model\PortalAccount;
use App\Model\Role;
use App\Model\User;
use App\RepositoryContracts\RoleRepository;
use App\ServiceContracts\RoleService;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{


    private $roleRepository;
    /**
     * @var RoleRepository
     */
    private $roleService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->generateLoginToken();
        $this->roleRepository = $this->app->make(RoleRepository::class);
        $this->roleService = $this->app->make(RoleService::class);
    }

    public function test_create_role()
    {

        $roleMock = [];
        for ($i = 0; $i <= 3; $i++) {
            $roleMock[] = [
                'name' => $this->faker->unique()->firstName,
            ];
        }

        $response = $this->asUser()
            ->json('POST', '/role-management/roles', [
                'roles' => $roleMock
            ]);


        $response->assertStatus(201);

        $response->assertJsonStructure([
            'message',
            'data' => [
                [

                    'id',
                    "name",
                    "code"
                ]

            ]]);

    }


    public function test_that_roles_are_created()
    {
        $roleMock = [];
        for ($i = 0; $i <= 3; $i++) {
            $roleMock[] = [
                'name' => $this->faker->unique()->firstName,
            ];
        }
        $this->asUser()->json('POST', '/role-management/roles', [
            'roles' => $roleMock
        ]);

        $roleCount = $this->roleRepository->getRoleCount();
        $this->assertEquals(4, $roleCount);
    }

    public function test_that_multiple_role_with_name_cannot_be_created()
    {

        $role = factory(Role::class, 3)
            ->create()->random()->toArray();

        $data = [
            'roles' => [
                $role
            ]
        ];
        $response = $this->asUser()->json('POST', '/role-management/roles', $data);

        $response->assertStatus(422);


    }

    public function test_assign_roles_to_user()
    {
        $role = factory(Role::class)->create();
        $portalAccount = factory(PortalAccount::class)->create();
        $user = factory(User::class)
            ->create();

        $user->portalAccounts()
            ->attach($portalAccount);
        $response = $this->asUser()
            ->json('POST', '/role-management/roles/' . $role->code . '/assign', [
                'userIdentifier' => $user->identifier,
                'portalAccountCode' => $portalAccount->code
            ]);
        $response->assertStatus(200);
    }


    public function test_get_a_role_by_code()
    {
        $role = factory(Role::class)->create();
        $uri = '/role-management/roles/' . $role->code;
        $response = $this
            ->asUser()
            ->json('GET', $uri);

        $response->assertStatus(200);
    }

    public function test_get_role_data_response()
    {
        $role = factory(Role::class)->create();
        $uri = '/role-management/roles/' . $role->code;
        $response = $this
            ->asUser()
            ->json('GET', $uri);

        $response->assertJson([
            'message' => 'successful',
            'data' => [
                'name' => $role->name,
                'code' => $role->code


            ]
        ], true);
        $response->assertStatus(200);
    }


    public function test_fetch_multiple_roles()
    {
        factory(Role::class, 4)->create();

        $response = $this
            ->asUser()
            ->json('GET', '/role-management/roles?offset=1&limit=1');


        $response->assertStatus(200);

    }

    public function test_a_role_is_added_to_membership_role()
    {

        $roles = factory(Role::class, 4)->create();


        $portalAccount = factory(PortalAccount::class)->create()->first();

        $user = factory(User::class)
            ->create()
            ->first();

        $user->portalAccounts()->attach($portalAccount);


        $roles->each(function ($role, $index) use ($portalAccount, $user) {
            $this->roleService->assignRoleToUser($portalAccount, $user, $role);
        });


        $role = factory(Role::class)->create();


        $response = $this
            ->asUser()
            ->json('POST', '/role-management/roles/' . $role->code . '/assign', [
                'userIdentifier' => $user->identifier,
                'portalAccountCode' => $portalAccount->code
            ]);

        $response->assertStatus(200);

        $membership = Membership::where('status', GenericStatusConstant::ACTIVE)
            ->where('user_id', $user->id)
            ->where('portal_account_id', $portalAccount->id)
            ->first();

        $this->assertEquals(5, $membership->roles()->count());

    }

}
