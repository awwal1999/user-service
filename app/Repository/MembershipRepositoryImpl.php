<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 09/04/2020
 * Time: 10:44 AM
 */

namespace App\Repository;


use App\Common\BaseRepository;
use App\Model\Enums\GenericStatusConstant;
use App\Model\Membership;
use App\Model\PortalAccount;
use App\Model\User;
use App\RepositoryContracts\MembershipRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MembershipRepositoryImpl extends BaseRepository implements MembershipRepository
{


    public function __construct(Membership $membership)
    {
        $this->model = $membership;
    }


    /**
     * @param User $user
     * @return Collection
     */

    public function getMembershipByUser(User $user): Collection
    {
        return $this
            ->join('portal_accounts', 'memberships.portal_account_id', 'portal_accounts.id')
            ->where('memberships.user_id', $user->id)
            ->where('portal_accounts.status', GenericStatusConstant::ACTIVE)
            ->with([
                'roles',
                'portalAccount'
            ])->get([
                'memberships.*'
            ]);


    }


    /**
     * @param PortalAccount $portalAccount
     * @param User $user
     * @return Model | Membership
     */
    public function getMembershipByPortalAccountAndUser(PortalAccount $portalAccount, User $user): Model
    {

        return $this
            ->where('portal_account_id', $portalAccount->id)
            ->where('user_id', $user->id)
            ->firstOrFail();
    }
}
