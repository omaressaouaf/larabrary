<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'slug' => $faker->unique()->slug,
        'description' => $faker->sentence(50),
        'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max = 500),
        'stock' => $faker->numberBetween(1, 1000),
        'user_id' => App\Role::where('name', 'author')->first()->users()->inRandomOrder()->take(1)->first()->id
    ];
});
