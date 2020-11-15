<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * @property PortalAccount portalAccount
 * @property Collection roles
 * @property integer portal_account_id
 * @property integer user_id
 */
class Membership extends Pivot
{

    protected $table = 'memberships';

    public function roles()
    {
        return $this
            ->belongsToMany(Role::class, 'membership_roles', 'membership_id', 'role_id')
            ->as('membershipRoles');
    }

    public function portalAccount()
    {
        return $this->belongsTo(PortalAccount::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
