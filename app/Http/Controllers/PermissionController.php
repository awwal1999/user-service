<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 05/06/2020
 * Time: 5:55 AM
 */

namespace App\Http\Controllers;


use App\Http\Requests\PermissionAssignRequest;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Model\Enums\GenericStatusConstant;
use App\RepositoryContracts\PermissionRepository;
use App\RepositoryContracts\RoleRepository;
use App\ServiceContracts\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    /**
     * @var PermissionService
     */
    private $permissionService;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;


    /**
     * PermissionController constructor.
     * @param PermissionService $permissionService
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionService $permissionService,
                                RoleRepository $roleRepository,
                                PermissionRepository $permissionRepository)
    {
        $this->permissionService = $permissionService;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function createPermission(PermissionRequest $permissionRequest)
    {
        $Permissions = $this->permissionService->createPermissions($permissionRequest->permissions);
        $response = $Permissions->values();
        return $this->successfulResponse(201, $response);
    }


    public function assignPermissionToRole(string $permissionCode, PermissionAssignRequest $permissionAssignRequest)
    {
        $permission = $this->permissionRepository->getFirstByColumns([
            'status' => GenericStatusConstant::ACTIVE,
            'code' => $permissionCode
        ]);

        $role = $this->roleRepository->getFirstByColumns([
            'status' => GenericStatusConstant::ACTIVE,
            'code' => $permissionAssignRequest->roleCode
        ]);

        $this->permissionService->assignPermissionToRole($permission, $role);

        return $this->successfulResponse(201);
    }

    public function get($code)
    {
        $permission = $this->permissionRepository->findByCode($code);
        return $this->successfulResponse(200, new PermissionResource($permission));
    }

    public function getAll(Request $request)
    {


        if ($request->has('status') && GenericStatusConstant::isValidValue($request->query('status'))) {
            $this->permissionRepository->where('status', $request->query('status'));
        }

        return $this->successfulResponse(200, $this->roleRepository
            ->paginate());
    }

}
