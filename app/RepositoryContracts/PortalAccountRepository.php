<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 28/05/2020
 * Time: 9:58 AM
 */

namespace App\RepositoryContracts;


use App\Common\Contracts\BaseRepositoryContract;
use App\Model\PortalAccount;
use App\Model\PortalAccountType;
use Illuminate\Database\Eloquent\Model;

interface PortalAccountRepository extends BaseRepositoryContract
{

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findByName(string $name): ?Model;


    /**
     * @param string $accountName
     * @param PortalAccountType $portalAccountType
     * @return PortalAccount
     */
    public function save(string $accountName, PortalAccountType $portalAccountType): PortalAccount;


}
