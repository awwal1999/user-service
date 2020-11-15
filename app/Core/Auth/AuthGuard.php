<?php


namespace App\Core\Auth;


use App\Contracts\AuthService;
use App\Exceptions\IllegalArgumentException;
use http\Client\Curl\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Concerns\InteractsWithInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthGuard implements Guard
{

    use InteractsWithInput;
    use GuardHelpers;

    protected $provider;
    /**
     * @var Authenticatable|null
     */
    protected $user;
    private $token;
    private $authService;
    private $request;

    /**
     * AuthGuard constructor.
     * @param UserProvider $userProvider
     * @param AuthService $authService
     * @param Request $request
     */
    public function __construct(UserProvider $userProvider, AuthService $authService, Request $request)
    {
        $this->provider = $userProvider;
        $this->authService = $authService;
        $this->request = $request;

    }

    /**
     * @return Authenticatable|null
     * @throws AuthenticationException
     */
    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }
        $user = null;
        $this->token = $this->request->bearerToken();
        if (empty($this->token)) {
            throw new AuthenticationException('Header must be provided');
        }
        $user = $this->provider->retrieveByToken(null, $this->token);
        return $user;
    }


    /**
     *
     * @throws AuthenticationException
     */
    public function id()
    {
        if ($user = $this->user()) {
            return $this->user()->getAuthIdentifier();
        }
        throw new AuthenticationException();
    }

    /**
     * @inheritDoc
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials['username']) || empty($credentials['password'])) {
            return false;
        }

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }


    /**
     * @param array $credentials
     * @param bool $issueToken
     * @return string|null
     * @throws IllegalArgumentException
     */
    public function attempt(array $credentials = [], $issueToken = false)
    {
        $requestPrincipal = $this->provider->retrieveByCredentials($credentials);



        if (is_null($requestPrincipal)) {
            throw new IllegalArgumentException('Credentials is not valid');

        }



        if ($this->provider->validateCredentials($requestPrincipal, $credentials)) {
            if ($issueToken) {
                return $this->authService->issueAuthToken($requestPrincipal->user());
            }

            return null;
        }

        throw new IllegalArgumentException('Provided Credentials is not valid');
    }


}
