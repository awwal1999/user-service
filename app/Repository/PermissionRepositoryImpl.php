<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 04/06/2020
 * Time: 11:43 PM
 */

namespace App\Repository;


use App\Common\BaseRepository;
use App\Model\Enums\GenericStatusConstant;
use App\Model\Permission;
use App\RepositoryContracts\PermissionRepository;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepositoryImpl extends BaseRepository implements PermissionRepository
{


    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }


    /**
     * @param array $attributes
     * @return Permission
     */
    public function save(array $attributes): Permission
    {

        $attributes = (object)$attributes;
        $permission = new Permission();
        $permission->code = null;
        $permission->name = $attributes->name;
        $permission->save();
        return $permission;
    }


    public function findByCodesIn($codes, $status = GenericStatusConstant::ACTIVE): Collection
    {
        return $this
            ->whereIn('code', $codes)
            ->where('status', $status)
            ->get();
    }


    public function findByCode($code, $status = GenericStatusConstant::ACTIVE)
    {
        return $this
            ->where('code', $code)
            ->where('status', $status)
            ->firstOrFail();
    }


    public function findByNameInPermissions(array $permissions, $status = GenericStatusConstant::ACTIVE)
    {
        $permissionNames = array_map(function ($permission) {
            return $permission['name'];
        }, $permissions);

        return $this->where('status', $status)
            ->whereIn('name', $permissionNames)
            ->get();
    }


    /**
     * @param GenericStatusConstant $status
     * @return int
     */
    public function getPermissionCount($status = GenericStatusConstant::ACTIVE): int
    {
        return $this->countByColumns([
            'status' => $status]);
    }

}
