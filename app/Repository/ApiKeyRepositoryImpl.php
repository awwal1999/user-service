<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 21/05/2020
 * Time: 2:41 PM
 */

namespace App\Repository;


use App\Common\BaseRepository;
use App\Model\ApiKey;
use App\RepositoryContracts\ApiKeyRepository;

class ApiKeyRepositoryImpl extends BaseRepository implements ApiKeyRepository
{

    public function __construct(ApiKey $apiKey)
    {

        $this->model = $apiKey;
    }
}
