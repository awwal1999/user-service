<?php

/** @var Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Model\PortalAccountType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->firstName,
        'code' => sprintf('ACCTYPE%s', $faker->unique()->bankAccountNumber)
    ];
});
