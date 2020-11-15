<?php


namespace App\Core\Auth;


use App\Contracts\AuthService;
use App\Exceptions\IllegalArgumentException;
use App\Facade\Console;
use App\Model\User;
use App\RepositoryContracts\UserDetailsRepository;
use App\RepositoryContracts\UserRepository;
use App\ServiceContracts\UserManagementService;
use Rhomans\Lookout\Contracts\GuardManager;
use Rhomans\Lookout\Contracts\Session;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use RuntimeException;


class AuthServiceImpl implements AuthService
{

    private $userRepository;
    /**
     * @var GuardManager
     */
    private $guardManager;
    /**
     * @var UserDetailsRepository
     */
    private $userDetailsRepository;
    /**
     * @var Session
     */
    private $session;


    /**
     * AuthServiceImpl constructor.
     * @param UserRepository $userRepository
     * @param Session $session
     * @param UserDetailsRepository $userDetailsRepository
     * @param GuardManager $guardManager
     */
    public function __construct(UserRepository $userRepository,
                                Session $session,
                                UserDetailsRepository $userDetailsRepository,
                                GuardManager $guardManager)
    {
        $this->userRepository = $userRepository;
        $this->guardManager = $guardManager;
        $this->session = $session;
        $this->userDetailsRepository = $userDetailsRepository;
    }


    /**
     * @param User $requestPrincipal
     * @return string
     */
    public function issueAuthToken(User $requestPrincipal): string
    {

        $userDetails = (object)($this->userDetailsRepository->getUserDetailsByUser($requestPrincipal));
        $userDetailsDataManager = new AuthUserDetailsDataManager($userDetails);
        return $this->session->createSession($userDetailsDataManager);
    }


    /**
     * @param string $token
     * @return User
     * @throws AuthenticationException
     */

    public function validateLoginToken(string $token): User
    {


        $claim = (object)$this->guardManager->getClaimFromToken($token);
        $username = $claim->identifier;
        $user = $this->userRepository->getUserByUsernameInApp($username);

        if (!$user) {
            throw new AuthenticationException('Provided token is not valid');
        }

        return $user;
    }


    /**
     * @param array $credentials
     * @return Authenticatable|null
     * @throws Exception
     */
    public function fetchUserByCredentials(Array $credentials): ?Authenticatable
    {
        $username = $credentials['username'];
        $password = $credentials['password'];
        if (is_null($username) || is_null($password)) {
            throw new IllegalArgumentException('username and password must be provided');
        }

        $user = $this->userRepository->getUserByUsernameInApp($username);
        if (!is_null($user)) {
            \App\Facade\RequestPrincipal::setUser($user);
            return \App\Facade\RequestPrincipal::get();
        }

        return null;

    }


}
