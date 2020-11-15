<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 05/06/2020
 * Time: 5:04 AM
 */

namespace App\ServiceContracts;


use App\Model\Permission;
use App\Model\Role;

interface PermissionService
{
    public function createPermissions(array $permissions);

    public function assignPermissionToRole(Permission $permission, Role $role);


}
