<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 27/05/2020
 * Time: 9:20 PM
 */


namespace App\ServiceContracts;


use App\Model\PortalAccount;
use App\Model\PortalAccountType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface PortalAccountService
{


    /**
     * @return PortalAccountType
     */
    public function createDefaultPortalAccountType(): PortalAccountType;


    /**
     * @return Builder|Model|PortalAccountType
     */
    public function getDefaultPortalAccountType(): PortalAccountType;


    /**
     * @param $accountName
     * @param PortalAccountType $portalAccountType
     * @return PortalAccount
     */
    public function createPortalAccount($accountName, PortalAccountType $portalAccountType): PortalAccount;


}
