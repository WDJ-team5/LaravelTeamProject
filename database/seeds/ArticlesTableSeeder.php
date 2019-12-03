<<<<<<< HEAD
<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::get()->each(function($user) {
            $user->articles()->save(factory(App\Article::class)->make());
        });
    }
}
=======
<?php	
use Illuminate\Database\Seeder;	
class ArticlesTableSeeder extends Seeder	
{	
    /**	
     * Run the database seeds.	
     *	
     * @return void	
     */	
    public function run()	
    {	
        App\User::get()->each(function($user) {	
            $user->articles()->save(factory(App\Article::class)->make());	
        });	
    }	
}
>>>>>>> c8a16b55ba50dc49170bea8741173f67b3b67ab5
