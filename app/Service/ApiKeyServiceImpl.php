<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 21/05/2020
 * Time: 1:13 PM
 */

namespace App\Service;


use App\Common\Contracts\ApiKeyUtils;
use App\Model\ApiKey;
use App\Model\PortalAccount;
use App\ServiceContracts\ApiKeyService;

class ApiKeyServiceImpl implements ApiKeyService
{

    /**
     * @var ApiKeyUtils
     */
    private $apiKeyUtils;

    /**
     * ApiKeyServiceIml constructor.
     * @param ApiKeyUtils $apiKeyUtils
     */
    public function __construct(ApiKeyUtils $apiKeyUtils)
    {
        $this->apiKeyUtils = $apiKeyUtils;
    }


    /**
     * @param PortalAccount $portalAccount
     * @return ApiKey
     */
    public function createApiKey(PortalAccount $portalAccount)
    {

        $apiKey = new ApiKey();
        $apiKey->key = $this->apiKeyUtils->generateAPIKey();
        $apiKey->portal_account_id = $portalAccount->id;
        $apiKey->save();
        return $apiKey;


    }
}
