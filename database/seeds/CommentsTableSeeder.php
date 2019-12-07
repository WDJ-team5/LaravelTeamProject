<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
		// App\User::get()->each(function($user) {	
		// 	$user->articles()->each(function($article) {
		// 		$article->comments()->save(factory(App\Comment::class)->make());	
		// 	});
		// });
		App\Article::get()->each(function($article) {
			$article->comments()->save(factory(App\Comment::class)->make());
		});
	}
}
