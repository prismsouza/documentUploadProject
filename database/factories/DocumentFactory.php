<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    $user_id = App\User::all()->random();
    $user = App\User::find($user_id)->first();
    $unit_id = $user->unit_id;
    return [
        'category_id' => function(){
            return App\Category::all()->random();
        },
        'name' => $faker->word,
        'description' => $faker->sentence,
        'file_name' => "bgbm.pdf",
        'user_id' => $user_id,
        'date' => $faker->date(),
        'is_active' => $faker->boolean,
        'unit_id' => $unit_id,
        'size' => "2 MB"
    ];
});
