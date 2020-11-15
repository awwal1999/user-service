<?php


namespace App\Facade;


use App\Model\User;
use Illuminate\Support\Facades\Facade;

/**
 * @method static get():
 * @method static setUser(User $user)
 * @method static user()
 * @method static roles()
 * @method static portalAccount()
 * @method static setPortalAccounts($portalAccounts)
 * @method static data()
 * @method static memberships()
 * @see \App\Core\Auth\RequestPrincipal
 */
class RequestPrincipal extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "requestPrincipal";
    }
}
