<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'sku' => $faker->numberBetween(1,2000),
        'price' => $faker->numberBetween(1,2000),
        'price' => $faker->text,
        'status' => $faker->numberBetween(1,2),
        'sphere' => $faker->numberBetween(1,3),
    ];
});
