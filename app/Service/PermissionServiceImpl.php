<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 05/06/2020
 * Time: 5:04 AM
 */

namespace App\Service;


use App\Exceptions\IllegalArgumentException;
use App\Model\Enums\GenericStatusConstant;
use App\Model\Permission;
use App\Model\Role;
use App\RepositoryContracts\PermissionRepository;
use App\ServiceContracts\PermissionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PermissionServiceImpl implements PermissionService
{
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * PermissionServiceImpl constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param Permission $permission
     * @param Role $role
     */
    public function assignPermissionToRole(Permission $permission, Role $role)
    {
        $role->permissions()->attach($permission);
    }





    /**
     * @param array $permissions
     * @return Collection
     */
    public function createPermissions(array $permissions)
    {
        return DB::transaction(function () use ($permissions) {
            $existingPermissions = $this->permissionRepository->findByNameInPermissions($permissions);

            foreach ($existingPermissions as $existingPermission) {
                throw new IllegalArgumentException(sprintf('Permission with name %s already exists', $existingPermission->name));
            }
            return collect($permissions)->transform(function ($permission) {
                return $this->permissionRepository->save($permission);
            });
        });
    }


}
