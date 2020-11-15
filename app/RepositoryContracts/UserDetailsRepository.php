<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 01/06/2020
 * Time: 9:17 AM
 */

namespace App\RepositoryContracts;


use App\Model\Enums\GenericStatusConstant;
use App\Model\User;

interface UserDetailsRepository
{


    /**
     * @param string $identifier
     * @param string $status
     * @return array
     */
    public function getUserDetailsByUserIdentifier(string $identifier,
                                                   $status = GenericStatusConstant::ACTIVE): array;

    /**
     * @param User $user
     * @param string $status
     * @return array
     */
    public function getUserDetailsByUser(User $user, $status = GenericStatusConstant::ACTIVE): array;

}
