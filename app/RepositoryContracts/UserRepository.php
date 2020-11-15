<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 28/05/2020
 * Time: 10:36 AM
 */


namespace App\RepositoryContracts;


use App\Common\Contracts\BaseRepositoryContract;
use App\Model\Enums\GenericStatusConstant;
use App\Model\User;
use Dlabs\PaginateApi\PaginateApiAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UserRepository extends BaseRepositoryContract
{

    /**
     * @param string $username
     * @param string $email
     * @param string $status
     * @return bool
     */
    public function countUserByEmailOrUsername(string $username,
                                               string $email, $status = 'ACTIVE'): bool;

    /**
     * @param string $username
     * @param string $status
     * @return Model | User
     */
    public function getUserByUsernameInApp(string $username, $status = GenericStatusConstant::ACTIVE): ?User;

    /**
     * @param string $email
     * @param string $status
     * @return Builder|Model|User
     */
    public function getUserByEmailInApp(string $email, $status = GenericStatusConstant::ACTIVE): User;


    /**
     * @param $attribute
     * @param $value
     * @return int
     */
    public function countByProvidedUserAttribute($attribute, $value): int;


    /**
     * @param array $attributes
     * @return User
     */
    public function save(array $attributes): User;


    /**
     * @param string $status
     * @param int $limit
     * @param int $offset
     * @return PaginateApiAwarePaginator
     */
    public function getUsers($status = GenericStatusConstant::ACTIVE, $limit = 20, $offset = 0);


    /**
     * @param string $identifier
     * @param string $status
     * @return object|null|User
     */
    public function getUserByIdentifier(string $identifier, $status = GenericStatusConstant::ACTIVE);


}
