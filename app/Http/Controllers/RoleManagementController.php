<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 06/04/2020
 * Time: 2:43 PM
 */

namespace App\Http\Controllers;


use App\Facade\RequestPrincipal;
use App\Http\Requests\AssignRoleRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Model\Enums\GenericStatusConstant;
use App\RepositoryContracts\MembershipRepository;
use App\RepositoryContracts\PortalAccountRepository;
use App\RepositoryContracts\RoleRepository;
use App\RepositoryContracts\UserRepository;
use App\ServiceContracts\RoleService;
use Illuminate\Http\Request;


class RoleManagementController extends BaseController
{

    /**
     * @var RoleService
     */
    private $roleService;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PortalAccountRepository
     */
    private $portalAccountRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var MembershipRepository
     */
    private $membershipRepository;

    /**
     * RoleManagementController constructor.
     * @param RoleService $roleService
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param MembershipRepository $membershipRepository
     * @param PortalAccountRepository $portalAccountRepository
     */
    public function __construct(RoleService $roleService,
                                UserRepository $userRepository,
                                RoleRepository $roleRepository,
                                MembershipRepository $membershipRepository,
                                PortalAccountRepository $portalAccountRepository)
    {
        $this->roleService = $roleService;
        $this->userRepository = $userRepository;
        $this->portalAccountRepository = $portalAccountRepository;
        $this->roleRepository = $roleRepository;
        $this->membershipRepository = $membershipRepository;
    }

    public function createRole(RoleRequest $request)
    {

        $createdRoles = $this->roleService->createRoles($request->roles);
        $response = $createdRoles->values();
        return $this->successfulResponse(201, $response);
    }

    public function assignRoleToUser(string $roleCode, AssignRoleRequest $request)
    {

        $user = $this->userRepository->getFirstByColumns([
            'status' => GenericStatusConstant::ACTIVE,
            'identifier' => $request->userIdentifier
        ]);
        $portalAccount = $this->portalAccountRepository->getFirstByColumns([
            'status' => GenericStatusConstant::ACTIVE,
            'code' => $request->portalAccountCode
        ]);

        $role = $this->roleRepository->getFirstByColumns([
            'status' => GenericStatusConstant::ACTIVE,
            'code' => $roleCode
        ]);
        $this->roleService->assignRoleToUser($portalAccount, $user, $role);
        return $this->successfulResponse();
    }


    public function get($code)
    {
        $role = $this->roleRepository->findRoleByCode($code);
        return $this->successfulResponse(200, new RoleResource($role));
    }


    public function getAll(Request $request)
    {


        if ($request->has('status') && GenericStatusConstant::isValidValue($request->query('status'))) {
            $this->roleRepository->where('status', $request->query('status'));
        }

        return $this->successfulResponse(200, $this->roleRepository
            ->paginate());


    }
}
