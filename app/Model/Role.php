<?php

namespace App\Model;

use App\Common\BaseModel;


/**
 * @property null code
 * @property string identifier
 * @property string name
 */
class Role extends BaseModel
{

    protected $hidden = [
        'updated_at', 'created_at'
    ];
    const ROLE_CODE_SEQUENCE = 'ROLE_CODE_SEQUENCE';


    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = sprintf("%s%05d", 'ROLE', $this->nextLong(self::ROLE_CODE_SEQUENCE));
    }

    public function permissions()
    {
        return $this
            ->belongsToMany(Permission::class, 'role_permissions', )
            ->using(RolePermission::class)
            ->as('role_permissions');
    }

}
