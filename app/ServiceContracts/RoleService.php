<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 27/05/2020
 * Time: 9:29 PM
 */


namespace App\ServiceContracts;

use App\Model\Membership;
use App\Model\Role;
use Illuminate\Database\Eloquent\Model;

interface RoleService
{

    /**
     * @param array $roles
     */
    public function createRoles(array $roles);

    /**
     * @param Membership $membership
     * @param Role $role
     * @return mixed
     */
    public function assignRoleToUser($portalAccount, $user, Role $role);


    /**
     * @param Membership $membership
     * @param Role $role
     * @return mixed
     */
    public function assignRoleToMembership(Membership $membership, Role $role);

}
