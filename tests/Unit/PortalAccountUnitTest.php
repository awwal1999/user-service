<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 21/05/2020
 * Time: 1:57 PM
 */

namespace Tests\Unit;

use App\Model\PortalAccountType;
use App\Repository\PortalAccountRepositoryImpl;
use App\RepositoryContracts\ApiKeyRepository;
use App\ServiceContracts\PortalAccountService;
use Tests\TestCase;

class PortalAccountUnitTest extends TestCase
{

    public function test_that_portal_account_creation_creates_api_key()
    {
        $portalAccountService = $this->app->make(PortalAccountService::class);
        $portalAccountName = sprintf('%s-%s', 'TEST', $this->faker->email);
        $portalAccountType = factory(PortalAccountType::class)->create();


        $portalAccountRepository = $this->app->make(PortalAccountRepositoryImpl::class);
        $countExistingPortalAccounts = $portalAccountRepository->count();
        $apiKeyRepository = $this->app->make(ApiKeyRepository::class);

        $countExistingApiKeys = $apiKeyRepository->count();


        foreach (range(0, 5) as $numbers) {
            $portalAccountService->createPortalAccount($portalAccountName, $portalAccountType);
        }

        $numberOfPortalAccount = $portalAccountRepository->count() - $countExistingPortalAccounts;
        $numberOfApiKeys = $apiKeyRepository->count() - $countExistingApiKeys;
        $this->assertEquals($numberOfPortalAccount, $numberOfApiKeys);
        $this->assertEquals(6, $numberOfPortalAccount);

    }
}
