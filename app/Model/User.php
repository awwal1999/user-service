<?php

namespace App\Model;

use App\Common\BaseModel;
use App\Model\Enums\GenericStatusConstant;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string username
 * @property string firstName
 * @property string lastName
 * @property string email
 * @property string password
 * @property mixed gender
 * @property string middleName
 * @property string nin
 * @property string bvn
 * @property string mothersMaidenName
 * @property string phoneNumber
 * @property mixed id
 * @property string identifier
 * @property GenericStatusConstant status
 * @property mixed dob
 */
class User extends BaseModel
{

    const USER_IDENTIFIER_SEQUENCE = 'USER_IDENTIFIER_SEQUENCE';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = ['status'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'id'
    ];

    protected $dates = ['created_at', 'updated_at', 'email_verified_at', 'dob'];


    /**
     * @return BelongsToMany
     */
    public function portalAccounts()
    {
        return $this
            ->belongsToMany(PortalAccount::class, 'memberships')
            ->using(Membership::class);
//            ->with(Membership::class)
//            ->as('memberships');
    }

    public function setIdentifierAttribute($value)
    {
        $this->attributes['identifier'] = sprintf("%s%05d", 'USER', $this->nextLong(self::USER_IDENTIFIER_SEQUENCE));
    }


}
