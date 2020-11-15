<?php

namespace App\Model;

use App\Common\BaseModel;

/**
 * @property string code
 * @property string name
 * @property int id
 * @property int type_id
 */
class PortalAccount extends BaseModel
{

    public const PORTAL_ACCOUNT_CODE_SEQUENCE = 'PORTAL_ACCOUNT_CODE_SEQUENCE';


    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'memberships')
            ->using(Membership::class)
            ->as('memberships');
    }


    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = sprintf("%s%05d", 'ACCT', $this->nextLong(self::PORTAL_ACCOUNT_CODE_SEQUENCE));
    }

}
