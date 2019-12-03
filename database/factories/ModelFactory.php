<<<<<<< HEAD
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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('oomori'),
        'name' => $faker->name,
        'birth' => now(),
        'gender' => 'slave',
        'activated' => '1',
    ];
});

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'article_type' => '아나까나',
        'title' => $faker->sentence(),
        'content' => $faker->paragraph()
    ];
});
=======
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
$factory->define(App\User::class, function (Faker $faker) {	
    return [	
        'email' => $faker->unique()->safeEmail,	
        'password' => bcrypt('oomori'),	
        'name' => $faker->name,	
        'birth' => now(),	
        'gender' => 'slave',	
        'activated' => '1',	
    ];	
});	
$factory->define(App\Article::class, function (Faker $faker) {	
    return [	
        'article_type' => '아나까나',	
        'title' => $faker->sentence(),	
        'content' => $faker->paragraph()	
    ];	
});
>>>>>>> c8a16b55ba50dc49170bea8741173f67b3b67ab5
