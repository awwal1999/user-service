<?php

namespace App\Http\Controllers;

use App\Contracts\AuthService;
use App\Facade\RequestPrincipal;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\RequestPrincipalResource;
use App\Http\Resources\UserDetailsResource;
use App\RepositoryContracts\UserDetailsRepository;
use App\ServiceContracts\UserManagementService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends BaseController
{

    /**
     * @var UserManagementService
     */
    private $authService;
    private $userManagementService;
    /**
     * @var UserDetailsRepository
     */
    private $userDetailsRepository;


    /**
     * AuthenticationController constructor.
     * @param AuthService $authService
     * @param UserDetailsRepository $userDetailsRepository
     * @param UserManagementService $userManagementService
     */
    public function __construct(AuthService $authService,
                                UserDetailsRepository $userDetailsRepository,
                                UserManagementService $userManagementService)
    {
        $this->authService = $authService;
        $this->userManagementService = $userManagementService;
        $this->userDetailsRepository = $userDetailsRepository;
    }


    public function login(LoginRequest $request)
    {


        $token = null;

        try {
            $token = Auth::guard('api')->attempt([
                'username' => $request->username,
                'password' => $request->password
            ], true);
        } catch (\Exception $ex) {
            throw new AuthenticationException('Provided credentials is not valid');
        }


        if ($token) {
            $user = RequestPrincipal::user();
            $userDetailsByUser = $this->userDetailsRepository->getUserDetailsByUser($user);
            $userDetailsResource = new UserDetailsResource((object)$userDetailsByUser);
            $userDetailsResource->setToken($token);
            return $userDetailsResource;
        }
        abort(401, 'user name or password is invalid');

    }


    public function me()
    {

        $requestPrincipal = RequestPrincipal::data();
        return $this->successfulResponse(200, new RequestPrincipalResource($requestPrincipal));

    }


}
