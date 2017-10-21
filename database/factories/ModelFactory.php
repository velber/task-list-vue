<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Task::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->text(120),
        'order' => rand(1, 99),
        'status_id' => rand(1, 3),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' =>  date('Y-m-d H:i:s'),
    ];
});
