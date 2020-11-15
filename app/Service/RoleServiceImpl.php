<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 06/04/2020
 * Time: 11:32 PM
 */

namespace App\Service;


use App\Exceptions\IllegalArgumentException;
use App\Model\Membership;
use App\Model\Role;

use App\RepositoryContracts\MembershipRepository;
use App\RepositoryContracts\RoleRepository;
use App\ServiceContracts\RoleService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleServiceImpl implements RoleService
{


    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var MembershipRepository
     */
    private $membershipRepository;


    /**
     * RoleServiceImpl constructor.
     * @param RoleRepository $roleRepository
     * @param MembershipRepository $membershipRepository
     */
    public function __construct(RoleRepository $roleRepository,
                                MembershipRepository $membershipRepository)
    {

        $this->roleRepository = $roleRepository;
        $this->membershipRepository = $membershipRepository;
    }


    /**
     * @param array $roles
     * @return Collection
     */
    public function createRoles(array $roles)
    {

        return DB::transaction(function () use ($roles) {
            $existingRoles = $this->roleRepository->findByNameInRoles($roles);
            foreach ($existingRoles as $existingRole) {
                throw new IllegalArgumentException(sprintf('role with %s or %s already exists', $existingRole['name'], $existingRole['identifier']));
            }
            return collect($roles)->transform(function ($role) {
                return $this->roleRepository->save($role);
            });
        });
    }


    /**
     * @param $portalAccount
     * @param $user
     * @param Role | Model $role
     */
    public function assignRoleToUser($portalAccount, $user, Role $role)
    {
        DB::transaction(function () use ($portalAccount, $user, $role) {
            $membership = $this->membershipRepository->getMembershipByPortalAccountAndUser($portalAccount, $user);
            $this->assignRoleToMembership($membership, $role);
        });
    }


    public function assignRoleToMembership(Membership $membership, Role $role)
    {
        $membership->roles()->attach($role);

    }


}
