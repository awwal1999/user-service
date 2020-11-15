<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 27/05/2020
 * Time: 9:17 PM
 */


namespace App\ServiceContracts;


use App\Model\PortalAccount;

interface ApiKeyService
{

    /**
     * @param PortalAccount $portalAccount
     * @return mixed
     */
    public function createApiKey(PortalAccount $portalAccount);
}
