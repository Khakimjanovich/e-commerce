<?php

/** @var Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => Str::slug($name),
        'excerpt' => $faker->sentence(2),
        'description' => $faker->sentence(5),
        'price' => $faker->randomDigit
    ];
});
