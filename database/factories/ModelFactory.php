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
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'delivery_address' => $faker->address,
        'phone' => $faker->phoneNumber
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'spam' => $faker->boolean(20),
        'name' => $faker->name,
        'email' => $faker->email,
        'created_at' => $faker->dateTimeBetween('-1 years'),
        'updated_at' => $faker->dateTimeBetween('-2 months')
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
        'checked' => $faker->boolean(),
        'created_at' => $faker->dateTimeBetween('-1 years'),
        'updated_at' => $faker->dateTimeBetween('-2 months')
    ];
});

$factory->define(App\PostTag::class, function (Faker\Generator $faker) {
    return [];
});

$factory->define(App\RolePermission::class, function (Faker\Generator $faker) {
    return [];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    $name = $faker->sentence(10);
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'description' => $faker->paragraph,
        'view' => random_int(0, 500000),
        'package' => $faker->words(6, true),
        'image' => $faker->imageUrl('370', '555'),
        'price' => $faker->randomFloat(10, 100000, 50000000)
    ];
});


$factory->define(App\Order::class, function (Faker\Generator $faker) {
    $created_at = $faker->dateTimeBetween('-2 years', '-2 days');
    $updated_at = $faker->dateTimeBetween($created_at);
    $canceled_at = $faker->dateTimeBetween($updated_at);

    return [
        'delivery_address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'customer_name' => $faker->firstName . ' ' . $faker->lastName,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
        'canceled_at' => $canceled_at
    ];
});

$factory->define(App\Taggable::class, function (Faker\Generator $faker) {
    return [];
});

$factory->define(App\UserRate::class, function (Faker\Generator $faker) {
    return [
        'rate' => $faker->randomFloat(4, 0, 100)
    ];
});

$factory->define(App\ProductReview::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'content' => $faker->paragraph,
        'checked' => $faker->boolean(),
        'rate' => $faker->randomFloat(5, 0, 100),
        'created_at' => $faker->dateTimeBetween('-1 years')
    ];
});

$factory->define(App\OrderProduct::class, function (Faker\Generator $faker) {
    return [
        'price' => $faker->randomFloat('10', 1000000, 90000000),
        'quantity' => $faker->randomNumber(3)
    ];
});
