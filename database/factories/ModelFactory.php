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
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker)
{
    $name = str_random(10);
    return [
      'name' => $name,
        'slug' => str_slug($name)
    ];
});
$factory->define(App\Comment::class, function (Faker\Generator $faker)
{
    return [
        'content' => $faker->paragraph,
        'user_id' =>factory(App\User::class)->create()->id,
        'post_id' =>factory(App\Post::class)->create()->id,
    ];
});
