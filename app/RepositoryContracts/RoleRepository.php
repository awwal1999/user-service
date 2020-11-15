<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 28/05/2020
 * Time: 10:12 AM
 */

namespace App\RepositoryContracts;


use App\Common\Contracts\BaseRepositoryContract;
use App\Model\Enums\GenericStatusConstant;
use App\Model\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepository extends BaseRepositoryContract
{


    /**
     * @param $attributes
     * @return Role
     */
    public function save($attributes): Role;


    /**
     * @param $roles
     * @return Collection
     */
    public function findByNameInRoles($roles): Collection;


    /**
     * @param $status
     * @return int
     */
    public function getRoleCount($status): int;


    /**
     * @param string $code
     * @param string $status
     * @return Role
     */
    public function findRoleByCode(string $code, $status = GenericStatusConstant::ACTIVE): Role;


}
