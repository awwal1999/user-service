<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 21/05/2020
 * Time: 12:29 AM
 */

namespace App\Service;


use App\Model\Membership;
use App\Model\PortalAccount;
use App\Model\User;
use App\RepositoryContracts\MembershipRepository;
use App\ServiceContracts\MembershipService;

class MembershipServiceImpl implements MembershipService
{


    /**
     * @var MembershipRepository
     */
    private $membershipRepository;

    public function __construct(MembershipRepository $membershipRepository)
    {
        $this->membershipRepository = $membershipRepository;
    }


    /**
     * @param User $user
     * @param PortalAccount $portalAccount
     * @return Membership
     */
    public function createMembership(User $user, PortalAccount $portalAccount): Membership
    {

        $membership = new Membership();
        $membership->portal_account_id = $portalAccount->id;
        $membership->user_id = $user->id;
        $membership->save();
        return $membership;


    }
}
