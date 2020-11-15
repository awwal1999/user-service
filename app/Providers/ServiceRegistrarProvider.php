<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 27/05/2020
 * Time: 9:29 PM
 */

namespace App\Providers;

use App\Service\PermissionServiceImpl;
use App\Service\UserDetailsRepositoryImpl;
use App\Service\UserManagementServiceImpl;
use App\ServiceContracts\ApiKeyService;
use App\ServiceContracts\MembershipService;
use App\ServiceContracts\PermissionService;
use App\ServiceContracts\PortalAccountService;
use App\ServiceContracts\RoleService;
use App\Service\ApiKeyServiceImpl;
use App\Service\MembershipServiceImpl;
use App\Service\PortalAccountServiceImpl;
use App\Service\RoleServiceImpl;
use App\ServiceContracts\UserDetailsService;
use App\ServiceContracts\UserManagementService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;


class ServiceRegistrarProvider extends ServiceProvider implements DeferrableProvider
{


    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        UserManagementService::class => UserManagementServiceImpl::class,
        ApiKeyService::class => ApiKeyServiceImpl::class,
        MembershipService::class => MembershipServiceImpl::class,
        PortalAccountService::class => PortalAccountServiceImpl::class,
        RoleService::class => RoleServiceImpl::class,
        PermissionService::class => PermissionServiceImpl::class
    ];


    public function provides()
    {
        return array_keys($this->singletons);
    }
}
