<?php

namespace App\Model;

use App\Common\BaseModel;

class Permission extends BaseModel
{

    protected $hidden = [
        'updated_at', 'created_at'
    ];
    const PERMISSION_CODE_SEQUENCE = 'PERMISSION_SEQUENCE';

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = sprintf("%s%05d", 'PERM', $this->nextLong(self::PERMISSION_CODE_SEQUENCE));
    }

}
