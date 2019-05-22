<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\User AS Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'password' => $faker->password,
        'nickname' => $faker->name,
        'mobile' => $faker->phoneNumber,
        'email' => $faker->email,
        'money' => $faker->randomNumber(3),
        'city' => $faker->city,
        'province' => $faker->citySuffix,
        'country' => $faker->country,
        'avatar' => $faker->imageUrl(120,120),
        'gender' => 1,
        'client_id' => 1,
        'last_login_time' => $faker->date('Y-m-d H:i:s'),
    ];
});
