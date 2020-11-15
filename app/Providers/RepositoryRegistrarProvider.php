<?php

namespace App\Providers;


use App\Repository\ApiKeyRepositoryImpl;
use App\Repository\MembershipRepositoryImpl;
use App\Repository\PermissionRepositoryImpl;
use App\Repository\PortalAccountRepositoryImpl;
use App\Repository\PortalAccountTypeRepositoryImpl;
use App\Repository\RoleRepositoryImpl;
use App\Repository\UserDetailsRepositoryImpl;
use App\Repository\UserRepositoryImpl;
use App\RepositoryContracts\ApiKeyRepository;
use App\RepositoryContracts\MembershipRepository;
use App\RepositoryContracts\PermissionRepository;
use App\RepositoryContracts\PortalAccountRepository;
use App\RepositoryContracts\PortalAccountTypeRepository;
use App\RepositoryContracts\RoleRepository;
use App\RepositoryContracts\UserDetailsRepository;
use App\RepositoryContracts\UserRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryRegistrarProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        ApiKeyRepository::class => ApiKeyRepositoryImpl::class,
        MembershipRepository::class => MembershipRepositoryImpl::class,
        PortalAccountRepository::class => PortalAccountRepositoryImpl::class,
        PortalAccountTypeRepository::class => PortalAccountTypeRepositoryImpl::class,
        RoleRepository::class => RoleRepositoryImpl::class,
        UserRepository::class => UserRepositoryImpl::class,
        UserDetailsRepository::class => UserDetailsRepositoryImpl::class,
        PermissionRepository::class => PermissionRepositoryImpl::class
    ];

    public function provides()
    {
        return array_keys($this->singletons);
    }
}
