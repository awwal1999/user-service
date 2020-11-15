<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 21/05/2020
 * Time: 1:28 AM
 */

namespace App\Repository;


use App\Common\BaseRepository;
use App\Model\PortalAccountType;
use App\RepositoryContracts\PortalAccountTypeRepository;

class PortalAccountTypeRepositoryImpl extends BaseRepository implements PortalAccountTypeRepository
{


    /**
     * PortalAccountTypeRepositoryImpl constructor.
     * @param PortalAccountType $portalAccountType
     */
    public function __construct(PortalAccountType $portalAccountType)
    {
        $this->model = $portalAccountType;

    }


}
