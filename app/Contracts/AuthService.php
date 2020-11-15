<?php


namespace App\Contracts;


use App\Model\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface AuthService
{
    public function issueAuthToken(User $requestPrincipal): string;

    public function validateLoginToken(String $token): User;

    public function fetchUserByCredentials(Array $credentials): ?Authenticatable;


}
