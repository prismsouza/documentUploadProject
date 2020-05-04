<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unit;
use Faker\Generator as Faker;

$factory->define(Unit::class, function (Faker $faker) {
    return [
        'id' => $faker->numberBetween(100,900),
        'name' => $faker->word
    ];
});
