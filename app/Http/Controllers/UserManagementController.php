<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 15/04/2020
 * Time: 1:10 PM
 */

namespace App\Http\Controllers;


use App\Events\PasswordResetEvent;
use App\Exceptions\IllegalArgumentException;
use App\Exceptions\NotFoundException;
use App\Facade\RequestPrincipal;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Resources\UserDetailsResource;
use App\Model\Enums\GenericStatusConstant;
use App\RepositoryContracts\UserDetailsRepository;
use App\RepositoryContracts\UserRepository;
use App\ServiceContracts\UserManagementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserManagementController extends BaseController
{


    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserManagementService
     */
    private $userManagementService;
    /**
     * @var UserDetailsRepository
     */
    private $userDetailsRepository;

    /**
     * UserManagementController constructor.
     * @param UserRepository $userRepository
     * @param UserDetailsRepository $userDetailsRepository
     * @param UserManagementService $userManagementService
     */
    public function __construct(UserRepository $userRepository,
                                UserDetailsRepository $userDetailsRepository,
                                UserManagementService $userManagementService)
    {
        $this->userRepository = $userRepository;
        $this->userManagementService = $userManagementService;
        $this->userDetailsRepository = $userDetailsRepository;
    }


    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function createUser(CreateUserRequest $request)
    {

        $attributes = $request->all();
        $result = $this
            ->userManagementService
            ->createUser($attributes);


        return $this->successfulResponse(201, $result);
    }


    public function getUsers(Request $request)
    {
        $userStatus = $request->query('status') ?? GenericStatusConstant::ACTIVE;
        $status = new GenericStatusConstant($userStatus);
        return $this->successfulResponse(200, $this->userRepository->getUsers($status->getValue()));
    }


    public function getUserByIdentifier($identifier)
    {
        $userMembership = $this
            ->userDetailsRepository
            ->getUserDetailsByUserIdentifier($identifier);


        return $this->successfulResponse(200, new UserDetailsResource((object)$userMembership));
    }


    public function deActivateAUserAccount($identifier)
    {

        $this
            ->userManagementService
            ->deactivateUser($identifier);

        return $this->successfulResponse();
    }

    public function validateEmail($token)
    {

        try {
            $this->userManagementService->validateEmail($token);
        } catch (IllegalArgumentException $ex) {
            throw new NotFoundException('Token is not valid');
        }


        return $this->successfulResponse(202);


    }

    public function onForgotPassword(PasswordResetRequest $request)
    {
        $user = $this->userRepository->getUserByEmailInApp($request->email);
        PasswordResetEvent::dispatch($user);
        return $this->successfulResponse(202);

    }


    public function doPasswordReset($token, ChangePasswordRequest $request)
    {

        $isPasswordReset = $this
            ->userManagementService
            ->doPasswordReset($token, $request->password);

        if ($isPasswordReset) {
            return $this->successfulResponse();
        }

        return abort(500);

    }

}
