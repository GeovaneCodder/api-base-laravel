<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Profile;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'role' => 'super_admin',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $faker->firstName,
    ];
});

$factory->afterCreating(User::class, function ($user, $faker) {
    $user
        ->profile()
        ->save(factory(Profile::class)->make());
});
