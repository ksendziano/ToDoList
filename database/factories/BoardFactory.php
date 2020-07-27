<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Board;
use Faker\Generator as Faker;

$factory->define(Board::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->name,
        'color' => '#0000FF',


    ];
});
