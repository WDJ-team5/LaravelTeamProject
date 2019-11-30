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
