<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        //'id'
        'theme_id' => function(){
            return Theme::all()->random();
        },
        'name' => $faker->title,
        'description' => $faker->sentence,
        'file_name' => "bgbm.pdf",
        'user_id' => function(){
            return User::all()->random();
        },
        'date' => $faker->date(),
        'is_active' => $faker->boolean,
        'unit_id' => function(){
            return Unit::all()->random();
        },
        'size' => "2 MB"
    ];
});
