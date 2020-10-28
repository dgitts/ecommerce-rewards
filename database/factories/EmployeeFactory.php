<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Employee;

$factory->define(Employee::class, function (Faker $faker) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $email = strtolower(substr($firstName, 0, 1).$lastName.'@'.$faker->safeEmailDomain);
    return [
        'id' => $faker->randomNumber(6),
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'cellPhone' => $faker->tollFreePhoneNumber
    ];
});
