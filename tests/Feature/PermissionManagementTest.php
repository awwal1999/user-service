<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 05/06/2020
 * Time: 8:49 PM
 */

namespace Tests\Feature;


use App\Facade\Console;
use App\Model\Permission;
use App\Model\PortalAccount;
use App\Model\Role;
use App\Model\User;
use App\RepositoryContracts\PermissionRepository;
use App\RepositoryContracts\RoleRepository;
use App\ServiceContracts\RoleService;
use Tests\TestCase;

class PermissionManagementTest extends TestCase
{


    /**
     * @var RoleService
     */
    private $roleService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->generateLoginToken();
        $this->roleService = $this->app->make(RoleService::class);
    }


    public function test_create_permission()
    {
        $permissionsMock = [];
        for ($i = 0; $i <= 3; $i++) {
            $permissionsMock[] = [
                'name' => $this->faker->unique()->firstName,
            ];
        }


        $data = [
            'permissions' => $permissionsMock
        ];
        $response = $this->asUser()
            ->json('POST', '/permission-management/permissions', $data);


        $response->assertStatus(201);


        $response->assertJsonStructure([
            'message',
            'data' => [
                [
                    "id",
                    "name",
                    "code"
                ]

            ]]);

    }

    public function test_count_of_all_permissions_created()
    {
        $roleMock = [];
        for ($i = 0; $i <= 3; $i++) {
            $roleMock[] = [
                'name' => $this->faker->unique()->firstName,
            ];
        }
        $this->asUser()->json('POST', '/permission-management/permissions', [
            'permissions' => $roleMock
        ]);

        $permissionRepository = app(PermissionRepository::class);
        $permissionRepositoryCount = $permissionRepository->getPermissionCount();
        $this->assertEquals(4, $permissionRepositoryCount);
    }

    public function test_that_multiple_permission_with_name_cannot_be_created()
    {

        $permission = factory(Permission::class, 3)
            ->create()->random()->toArray();

        $data = [
            'permissions' => [
                $permission
            ]
        ];

        $response = $this->asUser()->json('POST', '/permission-management/permissions', $data);
        $response->assertStatus(422);

    }

    public function test_assign_permissions_to_roles()
    {
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();
        $url = '/permission-management/permissions/' . $permission->code . '/assign';
        $response = $this->asUser()
            ->json('POST', $url, [
                'roleCode' => $role->code
            ]);


        $response->assertStatus(201);
    }

    public function test_get_a_permission_by_code()
    {
        $permission = factory(Permission::class)->create();
        $uri = '/permission-management/permissions/' . $permission->code;
        $response = $this
            ->asUser()
            ->json('GET', $uri);


        $response->assertStatus(200);
    }

    public function test_get_permission_by_code_data_response()
    {
        $permission = factory(Permission::class)->create();
        $uri = '/permission-management/permissions/' . $permission->code;
        $response = $this
            ->asUser()
            ->json('GET', $uri);

        $response->assertJson([
            'message' => 'successful',
            'data' => [
                'name' => $permission->name,
                'code' => $permission->code,


            ]
        ], true);
        $response->assertStatus(200);
    }

    public function test_fetch_multiple_permissions()
    {
        factory(Role::class, 4)->create();

        $response = $this
            ->asUser()
            ->json('GET', '/permission-management/permissions?offset=1&limit=1');


        $response->assertStatus(200);

    }

}
