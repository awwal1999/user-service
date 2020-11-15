<?php

namespace App\Model;

use App\Common\BaseModel;

/**
 * @property null code
 * @property string name
 * @property int client_id
 * @property int type_id
 */
class PortalAccountType extends BaseModel
{
    public const PORTAL_ACCOUNT_TYPE_CODE_SEQUENCE = 'PORTAL_ACCOUNT_TYPE_CODE_SEQUENCE';

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = sprintf("%s%05d", 'ACCTYPE', $this->nextLong(self::PORTAL_ACCOUNT_TYPE_CODE_SEQUENCE));
    }
}
