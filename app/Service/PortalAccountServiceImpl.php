<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 21/05/2020
 * Time: 12:28 AM
 */

namespace App\Service;



use App\Model\Enums\GenericStatusConstant;
use App\Model\PortalAccount;
use App\Model\PortalAccountType;
use App\RepositoryContracts\PortalAccountRepository;
use App\ServiceContracts\ApiKeyService;
use App\ServiceContracts\PortalAccountService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PortalAccountServiceImpl implements PortalAccountService
{
    /**
     * @var PortalAccountRepository
     */
    private $portalAccountTypeRepository;
    /**
     * @var PortalAccountRepository
     */
    private $portalAccountRepository;
    /**
     * @var ApiKeyService
     */
    private $apiKeyService;


    /**
     * PortalAccountServiceImpl constructor.
     * @param PortalAccountRepository $portalAccountTypeRepository
     * @param ApiKeyService $apiKeyService
     * @param PortalAccountRepository $portalAccountRepository
     */
    public function __construct(PortalAccountRepository $portalAccountTypeRepository,
                                ApiKeyService $apiKeyService,
                                PortalAccountRepository $portalAccountRepository)
    {
        $this->portalAccountTypeRepository = $portalAccountTypeRepository;
        $this->portalAccountRepository = $portalAccountRepository;
        $this->apiKeyService = $apiKeyService;
    }

    public function createDefaultPortalAccountType(): PortalAccountType
    {
        $portalAccountType = new PortalAccountType();
        $portalAccountType->code = null;
        $portalAccountType->name = 'INDIVIDUAL';
        $portalAccountType->save();
        return $portalAccountType;
    }

    /**
     * @return Builder|Model|PortalAccountType
     */
    public function getDefaultPortalAccountType(): PortalAccountType
    {

        return $this->portalAccountTypeRepository->getFirstOrElse([
            'status' => GenericStatusConstant::ACTIVE,
            'name' => 'INDIVIDUAL'
        ], function () {
            return $this->createDefaultPortalAccountType();
        });

    }


    /**
     * @param $accountName
     * @param PortalAccountType $portalAccountType
     * @return PortalAccount
     */
    public function createPortalAccount($accountName, PortalAccountType $portalAccountType): PortalAccount
    {
        $portalAccount = $this->portalAccountRepository->save($accountName, $portalAccountType);
        $this->apiKeyService->createApiKey($portalAccount);
        return $portalAccount;


    }
}
