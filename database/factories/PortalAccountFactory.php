<?php

/** @var Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Model\PortalAccount::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->firstName,
        'code' => $faker->unique()->bankAccountNumber,
        'type_id' => factory(Model\PortalAccountType::class)
    ];
});
