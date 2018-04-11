<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/4/11
 */
use Faker\Generator as Faker;

$factory->define(App\Models\ArticleContent::class, function(Faker $faker) {
    return [
        'content' => $faker->realText()
    ];
});