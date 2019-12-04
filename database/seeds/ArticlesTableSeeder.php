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
		for($i=1;$i<30;$i++) {
			App\User::find($i)->articles()->create([	
				'article_type' => 'LS',
				'title' => '현지학기줴 제목'.$i,
				'content' => '현지학기제 내용'.$i,
        	]);
		}
		
        App\User::get()->each(function($user) {	
            $user->articles()->save(factory(App\Article::class)->make());	
        });	
    }	
}
