<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 28/05/2020
 * Time: 9:39 AM
 */

namespace App\RepositoryContracts;


use App\Common\Contracts\BaseRepositoryContract;
use App\Model\PortalAccount;
use App\Model\User;
use Illuminate\Database\Eloquent\Collection;

interface MembershipRepository extends BaseRepositoryContract
{


    /**
     * @param User $user
     * @return Collection
     */
    public function getMembershipByUser(User $user): Collection;

    public function getMembershipByPortalAccountAndUser(PortalAccount $portalAccount, User $user);
}
