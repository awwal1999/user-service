<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 04/06/2020
 * Time: 11:41 PM
 */

namespace App\RepositoryContracts;


use App\Common\Contracts\BaseRepositoryContract;
use App\Model\Enums\GenericStatusConstant;
use Illuminate\Database\Eloquent\Collection;


interface PermissionRepository extends BaseRepositoryContract
{


    public function save(array $attributes);

    public function findByCodesIn($codes, $status = GenericStatusConstant::ACTIVE): Collection;

    public function findByNameInPermissions(array $permissions, $status = GenericStatusConstant::ACTIVE);

    public function getPermissionCount($status = GenericStatusConstant::ACTIVE);

    public function findByCode($code, $status = GenericStatusConstant::ACTIVE);

}
