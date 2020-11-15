<?php


namespace App\Core\Auth;


use App\Model\Enums\GenericStatusConstant;
use App\Model\Membership;
use App\Model\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

class RequestPrincipal implements Authenticatable
{


    private $user;
    private $roles;
    private $portalAccounts;
    private $memberships = [];


    /**
     * @param Collection $portalAccount
     */
    private function setPortalAccounts(Collection $portalAccount)
    {
        $this->portalAccounts = $portalAccount;
    }


    /**
     * @return Collection
     */
    public function portalAccounts()
    {
        return $this->portalAccounts;
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }


    /**
     * @return int
     */
    public function getAuthIdentifier()
    {

        // Todo Let this return an object of username or email
        // Todo Any one using it can use any of choice!!!
        return $this->user->username;
    }


    /**
     * @return mixed|string
     */
    public function getAuthPassword()
    {
        return $this->user->password;
    }


    public function getRememberToken()
    {

    }


    public function setRememberToken($value)
    {

    }


    /**
     * @param User $user
     */
    public function setUser(User $user)
    {

        $this->user = $user;
    }


    /**
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * @return Collection
     */
    public function roles()
    {
        return $this->roles;
    }

    public function setRoles(Collection $roles)
    {
        $this->roles = $roles;
    }


    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }

    public function get(): RequestPrincipal
    {

        return $this;
    }


    public function data(): RequestPrincipal
    {
        $memberships = Membership::with('portalAccount', 'roles')
            ->where('user_id', $this->user->id)
            ->where('status', GenericStatusConstant::ACTIVE)
            ->get();


        $portalAccounts = $memberships->map(function ($membership, $i) {
            $this->setRoles($membership->roles);
            $this->setPortalAccountRoles($membership);
            return $membership->portalAccount;
        });

        $this->setPortalAccounts($portalAccounts);
        return $this;
    }

    public function memberships()
    {
        return $this->memberships;
    }


    private function setPortalAccountRoles(Membership $membership)
    {

        $memberRecord = [
            'portalAccount' => $membership->portalAccount,
            'roles' => $membership->roles
        ];

        $this->memberships[] = $memberRecord;
    }


}
