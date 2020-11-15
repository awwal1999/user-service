<?php


namespace App\Core\Auth {


    use App\Contracts\AuthService;
    use Illuminate\Auth\AuthenticationException;
    use Illuminate\Contracts\Auth\Authenticatable;
    use Illuminate\Contracts\Auth\UserProvider;
    use Illuminate\Support\Facades\Hash;

    class AuthUserProvider implements UserProvider
    {


        private $authService;

        /**
         * AuthUserProvider constructor.
         * @param AuthService $authService
         */
        public function __construct(AuthService $authService)
        {
            $this->authService = $authService;
        }

        public function retrieveById($identifier)
        {

        }


        /**
         * @param mixed $identifier
         * @param string $token
         * @return Authenticatable|null
         * @throws AuthenticationException
         */
        public function retrieveByToken($identifier, $token)
        {
            $user = $this->authService->validateLoginToken($token);
            if (is_null($user)) {
                throw new AuthenticationException();
            }

            \App\Facade\RequestPrincipal::setUser($user);

            return \App\Facade\RequestPrincipal::get();

        }

        public function updateRememberToken(Authenticatable $user, $token)
        {
            // TODO: Implement updateRememberToken() method.
        }


        public function retrieveByCredentials(array $credentials)
        {
            return $this->authService->fetchUserByCredentials($credentials);
        }


        public function validateCredentials(Authenticatable $requestPrincipal, array $credentials)
        {
            return (trim($credentials['username']) == trim($requestPrincipal->getAuthIdentifier())
                &&
                Hash::check(trim($credentials['password']), $requestPrincipal->getAuthPassword())
            );
        }


    }
}
