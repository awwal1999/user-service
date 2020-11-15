<?php


namespace App\Repository;


use App\Common\BaseRepository;
use App\Model\Enums\GenericStatusConstant;
use App\Model\User;
use App\RepositoryContracts\UserRepository;
use Carbon\Carbon;
use Dlabs\PaginateApi\PaginateApiAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImpl extends BaseRepository implements UserRepository
{
    /**
     * UserRepositoryImpl constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }


    /**
     * @param string $username
     * @param string $email
     * @param string $status
     * @return bool
     */
    public function countUserByEmailOrUsername(string $username,
                                               string $email, $status = 'ACTIVE'): bool
    {

        return $this
            ->join('memberships', 'memberships.user_id', 'users.id')
            ->join('portal_accounts', 'portal_accounts.id', 'memberships.portal_account_id')
            ->where('users.status', $status)
            ->where('memberships.status', $status)
            ->where('portal_accounts.status', $status)
            ->where(function ($query) use ($username, $email) {
                $query->where('users.username', $username)
                    ->orWhere('users.email', $email);
            })
            ->count();
    }


    /**
     * @param string $username
     * @param string $status
     * @return Model | User
     */
    public function getUserByUsernameInApp(string $username, $status = GenericStatusConstant::ACTIVE): ?User
    {

        return $this
            ->getUserInAppBuilder($status)
            ->where('users.username', $username)
            ->first(['users.*']);
    }


    /**
     * @param string $email
     * @param string $status
     * @return Builder|Model|User
     */
    public function getUserByEmailInApp(string $email, $status = GenericStatusConstant::ACTIVE): User
    {
        return $this
            ->getUserInAppBuilder($status)
            ->where('users.email', $email)
            ->firstOrFail(['users.*']);
    }


    /**
     * @param $attribute
     * @param $value
     * @return int
     */
    public function countByProvidedUserAttribute($attribute, $value): int
    {
        return $this
            ->join('memberships', 'memberships.user_id', 'users.id')
            ->join('portal_accounts', 'portal_accounts.id', 'memberships.portal_account_id')
            ->where('users.' . $attribute, $value)
            ->where('memberships.status', 'ACTIVE')
            ->where('portal_accounts.status', 'ACTIVE')
            ->count();
    }


    /**
     * @param array $attributes
     * @return User
     */
    public function save(array $attributes): User
    {
        $userAttribute = (object)$attributes;
        $optionalUser = optional($userAttribute);
        $validateEmail = $optionalUser->validateEmail ?? false;
        $status = !$validateEmail ? GenericStatusConstant::ACTIVE : GenericStatusConstant::PENDING;
        $user = new User();
        $user->username = $optionalUser->username;
        $user->firstName = $optionalUser->firstName;
        $user->lastName = $optionalUser->lastName;
        $user->email = $optionalUser->email;
        $user->password = Hash::make($optionalUser->password);
        $user->gender = $optionalUser->gender;
        $user->middleName = $optionalUser->middleName;
        $user->nin = $optionalUser->nin;
        $user->bvn = $optionalUser->bvn;
        $user->identifier = null;
        $user->status = $status;
        $user->phoneNumber = $optionalUser->phoneNumber;
        optional($optionalUser->dob, function ($dob) use ($user) {
            $user->dob = Carbon::createFromFormat('Y-m-d', $dob)->startOfDay()->toDateTimeString();
        });
        $user->mothersMaidenName = $optionalUser->mothersMaidenName;
        $user->save();
        return $user;
    }


    /**
     * @param string $status
     * @param int $limit
     * @param int $offset
     * @return PaginateApiAwarePaginator
     */
    public function getUsers($status = GenericStatusConstant::ACTIVE, $limit = 20, $offset = 0)
    {
        return $this->userInBuilder($status)
            ->paginate($limit, $offset, [
                'users.*'
            ]);
    }


    /**
     * @param string $identifier
     * @param string $status
     * @return object|null|User
     */
    public function getUserByIdentifier(string $identifier, $status = GenericStatusConstant::ACTIVE)
    {


        return $this
            ->userInBuilder($status)
            ->where('users.identifier', $identifier)
            ->firstOrFail([
                'users.*'
            ]);
    }


    /**
     * @param $status
     * @return UserRepositoryImpl
     */
    private function userInBuilder($status): UserRepositoryImpl
    {
        return $this->join('memberships', 'memberships.user_id', 'users.id')
            ->join('portal_accounts', 'portal_accounts.id', 'memberships.portal_account_id')
            ->where('users.status', $status)
            ->where('memberships.status', 'ACTIVE')
            ->where('portal_accounts.status', 'ACTIVE');
    }


    /**
     * @param $status
     * @return UserRepositoryImpl
     */
    private function getUserInAppBuilder($status): UserRepositoryImpl
    {

        return $this
            ->join('memberships', 'memberships.user_id', 'users.id')
            ->join('portal_accounts', 'portal_accounts.id', 'memberships.portal_account_id')
            ->where('users.status', $status)
            ->where('memberships.status', $status)
            ->where('portal_accounts.status', $status);


    }


}
