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

/**
 * User factories
 */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'admin', function(Faker\Generator $faker) use($factory)
{
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['is_admin' => true]);
});

/**
 * Product factories
 */
$factory->define(App\Product::class, function(Faker\Generator $faker)
{
    return [
        'name' => ucwords($faker->word.' '.$faker->word),
        'price' => $faker->randomFloat(2, 0, 200),
        'target_profit_percentage' => $faker->randomFloat(2, 0, 100),
    ];
});

/**
 * Stock factories
 */
$factory->define(App\Stock::class, function(Faker\Generator $faker)
{
    $amount = $faker->numberBetween(1, 100);

    return [
        'amount' => $amount,
        'in_stock' => $amount,
        'cost' => $faker->randomFloat(2, 0, 200)
    ];
});
