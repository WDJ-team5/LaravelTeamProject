<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function () {
    return [
        'rank' => 'A',
        'email' => 'root@oomori.org',
        'password' => bcrypt('oomori'),
        'name' => '관리자',
        'birth' => now(),
        'gender' => 'god',
        'hint' => '나보다 약한 녀석들의 명령은 듣지 않는다.',
        'answer' => bcrypt(bcrypt(1234)),
        'activated' => '1',
    ];
});


/* $factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'remember_token' => Str::random(10),
    ];
}); */
