<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 01/06/2020
 * Time: 9:17 AM
 */

namespace App\Repository;


use App\Model\Enums\GenericStatusConstant;
use App\Model\User;
use App\RepositoryContracts\MembershipRepository;
use App\RepositoryContracts\UserDetailsRepository;
use App\RepositoryContracts\UserRepository;


class UserDetailsRepositoryImpl implements UserDetailsRepository
{
    /**
     * @var MembershipRepository
     */
    private $membershipRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;


    /**
     * UserDetailsServiceImpl constructor.
     * @param MembershipRepository $membershipRepository
     * @param UserRepository $userRepository
     */
    public function __construct(MembershipRepository $membershipRepository,
                                UserRepository $userRepository)
    {
        $this->membershipRepository = $membershipRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $identifier
     * @param string $status
     * @return array
     */
    public function getUserDetailsByUserIdentifier(string $identifier, $status = GenericStatusConstant::ACTIVE): array
    {

        $user = $this->userRepository->getUserByIdentifier($identifier, $status);
        $memberships = $this->membershipRepository->getMembershipByUser($user);


        return [
            'user' => $user,
            'memberships' => $memberships
        ];

    }


    /**
     * @param User $user
     * @param string $status
     * @return array
     */
    public function getUserDetailsByUser(User $user, $status = GenericStatusConstant::ACTIVE): array
    {
        $memberships = $this->membershipRepository->getMembershipByUser($user);


        return [
            'user' => $user,
            'memberships' => $memberships
        ];
    }

}
