<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 27/05/2020
 * Time: 9:19 PM
 */

namespace App\ServiceContracts;


use App\Model\Membership;
use App\Model\PortalAccount;
use App\Model\User;

interface MembershipService
{


    /**
     * @param User $user
     * @param PortalAccount $portalAccount
     * @return Membership
     */
    public function createMembership(User $user, PortalAccount $portalAccount): Membership;
}
