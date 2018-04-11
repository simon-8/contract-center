<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/4/11
 */
use Faker\Generator AS Faker;

$factory->define(App\Models\Article::class, function(Faker $faker) {
    return [
        'catid' => $faker->numberBetween(2, 5),
        'title' => $faker->text(15),
        'introduce' => $faker->sentences(1, true),
        'thumb' => '',
        'username' => $faker->userName,
        'comment' => $faker->numberBetween(0, 1000),
        'zan' => $faker->numberBetween(0, 1000),
        'hits' => $faker->numberBetween(0, 1000),
        'status' => 1,
    ];
});