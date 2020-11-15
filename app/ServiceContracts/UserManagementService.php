<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 27/05/2020
 * Time: 9:32 PM
 */


namespace App\ServiceContracts;


use App\Exceptions\IllegalArgumentException;
use App\Model\User;

interface UserManagementService
{

    /**
     * @param array $attributes
     * @return User
     */
    public function createUser(array $attributes): User;


    /**
     * @param string $identifier
     * @return bool
     */
    public function deactivateUser(string $identifier): bool;

    /**
     * @param $token
     * @return bool
     * @throws IllegalArgumentException
     */
    public function validateEmail($token): bool;


    /**
     * @param string $token
     * @param string $newPassword
     * @return mixed
     */
    public function doPasswordReset(string $token, string $newPassword);


    /**
     * @param User $user
     * @return string
     */
    public function generateUserRefreshToken(User $user): string;


}
