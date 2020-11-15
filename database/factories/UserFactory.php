<?php

/** @var Factory $factory */


use App\Model\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->safeEmail,
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'gender' => 'MALE',
        'middleName' => $faker->name,
        'nin' => $faker->bankAccountNumber,
        'bvn' => $faker->bankAccountNumber,
        'identifier' => $faker->bankAccountNumber,
        'phoneNumber' => $faker->phoneNumber,
        'mothersMaidenName' => $faker->name,
        'password' => Hash::make($faker->password(7, 10))
    ];
});
