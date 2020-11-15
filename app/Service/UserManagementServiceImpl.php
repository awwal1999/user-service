<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 27/05/2020
 * Time: 9:32 PM
 */

namespace App\Service;


use App\Contracts\AuthService;
use App\Events\UserRegisteredEvent;
use App\Exceptions\IllegalArgumentException;
use App\Model\Enums\GenericStatusConstant;
use App\Model\User;
use App\RepositoryContracts\MembershipRepository;
use App\RepositoryContracts\PortalAccountRepository;
use App\RepositoryContracts\PortalAccountTypeRepository;
use App\RepositoryContracts\UserRepository;
use App\ServiceContracts\MembershipService;
use App\ServiceContracts\PortalAccountService;
use App\ServiceContracts\UserManagementService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagementServiceImpl implements UserManagementService
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var PortalAccountRepository
     */
    private $portalAccountRepository;
    /**
     * @var MembershipRepository
     */
    private $membershipRepository;
    /**
     * @var AuthService
     */
    private $authService;
    /**
     * @var MembershipService
     */
    private $membershipService;
    /**
     * @var PortalAccountService
     */
    private $portalAccountService;
    /**
     * @var PortalAccountTypeRepository
     */
    private $portalAccountTypeRepository;


    /**
     * UserManagementServiceImpl constructor.
     * @param UserRepository $userRepository
     * @param MembershipService $membershipService
     * @param MembershipRepository $membershipRepository
     * @param AuthService $authService
     * @param PortalAccountService $portalAccountService
     * @param PortalAccountTypeRepository $portalAccountTypeRepository
     * @param PortalAccountRepository $portalAccountRepository
     */
    public function __construct(UserRepository $userRepository,
                                MembershipService $membershipService,
                                MembershipRepository $membershipRepository,
                                AuthService $authService,
                                PortalAccountService $portalAccountService,
                                PortalAccountTypeRepository $portalAccountTypeRepository,
                                PortalAccountRepository $portalAccountRepository)
    {
        $this->userRepository = $userRepository;
        $this->portalAccountRepository = $portalAccountRepository;
        $this->membershipRepository = $membershipRepository;
        $this->authService = $authService;
        $this->membershipService = $membershipService;
        $this->portalAccountService = $portalAccountService;
        $this->portalAccountTypeRepository = $portalAccountTypeRepository;
    }


    /**
     * @param array $attributes
     * @return User
     */
    public function createUser(array $attributes): User
    {

        return DB::transaction(function () use ($attributes) {
            $portalAccount = null;

            if (array_key_exists('accountCode', $attributes)) {
                $portalAccount = $this->portalAccountRepository->getFirstByColumns([
                    "code" => $attributes['accountCode'],
                    "status" => GenericStatusConstant::ACTIVE,
                ]);


                if (is_null($portalAccount)) {
                    throw new IllegalArgumentException('Provided portal account does not exist');
                }

            } else {
                $portalAccount = $this
                    ->portalAccountRepository
                    ->findByName($attributes['username']);

                if ($portalAccount) {
                    throw new IllegalArgumentException(sprintf('username %s already exists', $attributes['username']));
                }


                $optionalUserAttribute = optional((object)$attributes);
                $portalAccountType = optional($optionalUserAttribute->portalAccountTypeCode, function ($portalAccountCode) {
                    return $this->portalAccountTypeRepository->getFirstByColumns([
                        'status' => GenericStatusConstant::ACTIVE,
                        'code' => $portalAccountCode
                    ]);
                });

                $portalAccountType = $portalAccountType ?? $this->portalAccountService->getDefaultPortalAccountType();


                $portalAccount = $this->portalAccountService->createPortalAccount($attributes['username'], $portalAccountType);

            }

            $countUser = $this
                ->userRepository
                ->countUserByEmailOrUsername($attributes['username'], $attributes['email']);

            if ($countUser) {
                throw new IllegalArgumentException(sprintf('username %s already or email %s exists with this account %s,', $attributes['username'], $attributes['email'], $portalAccount->name));
            }

            $user = $this->userRepository->save($attributes);
            $this->membershipService->createMembership($user, $portalAccount);

            if ($user->status == GenericStatusConstant::PENDING) {
                event(new UserRegisteredEvent($user));
            }


            return $user;

        });
    }


    /**
     * @param string $identifier
     * @return bool
     */
    public function deactivateUser(string $identifier): bool
    {

        $user = $this->userRepository->getUserByIdentifier($identifier, GenericStatusConstant::ACTIVE);
        $user->status = GenericStatusConstant::IN_ACTIVE;
        $user->save();

        return $user->status == GenericStatusConstant::IN_ACTIVE;
    }


    /**
     * @param $token
     * @return bool
     * @throws IllegalArgumentException
     */
    public function validateEmail($token): bool
    {

        $username = $this->decrptUserDefinedToken($token);

        $user = $this->userRepository->getFirstByColumns([
            'username' => $username,
            'status' => GenericStatusConstant::PENDING
        ]);
        $user->status = GenericStatusConstant::ACTIVE;
        return $user->save();
    }

    public function generateUserRefreshToken(User $user): string
    {
        $userInformation = [
            'username' => $user->username
        ];

        return encrypt(json_encode($userInformation));
    }


    private function decrptUserDefinedToken($token)
    {
        try {
            $userInformation = json_decode(decrypt($token));
            $username = $userInformation->username;

        } catch (Exception $ex) {
            throw new IllegalArgumentException('Link is not valid');
        }

        return $username;
    }


    public function doPasswordReset(string $token, string $newPassword): bool
    {

        $username = $this->decrptUserDefinedToken($token);

        $user = $this->userRepository->getFirstByColumns([
            'username' => $username,
            'status' => GenericStatusConstant::ACTIVE
        ]);
        $user->password = Hash::make($newPassword);
        return $user->save();


    }
}
