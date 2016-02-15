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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $verified = rand(0, 1) ? true : false;
    return [
        'name' => $faker->userName,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'verified' => $verified,
        'verify_token' => !$verified ? str_random(10) : null,
        'banned' => $faker->boolean(25),
        'expired_at' => $faker->dateTimeBetween('+2 days', '+2 years'),
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'spam' => $faker->boolean(20),
        'name' => $faker->name,
        'email' => $faker->email
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    $name = $faker->words(3, true);
    return [
        'name' => $name,
        'slug' => str_slug($name)
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    $title = $faker->sentence(10);
    return [
        'title' => $title,
        'slug' => str_slug($title),
        'content' => $faker->paragraph,
        'view' => random_int(0, 500000),
        'published' => $faker->boolean(),
        'published_at' => $faker->dateTimeBetween('-1 years', 'now')
    ];
});

$factory->define(App\Feedback::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'checked' => random_int(0,1),
        'created_at' => $faker->dateTimeBetween('-1 years')
    ];
});

$factory->define(App\PostTag::class, function (Faker\Generator $faker) {
    return [];
});