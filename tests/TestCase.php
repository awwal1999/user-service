<?php

namespace Tests;

use App\Contracts\AuthService;
use App\ServiceContracts\UserManagementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithStubUser;


    protected function setUp(): void
    {

        parent::setUp();
        $this->faker = Faker::create();
        $this->userManagementService = app()->make(UserManagementService::class);
        $this->authService = app()->make(AuthService::class);
    }
}
