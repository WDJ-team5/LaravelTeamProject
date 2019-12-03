<<<<<<< HEAD
<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'rank' => 'A',
            'email' => 'root@oomori.org',
            'password' => bcrypt('oomori'),
            'name' => '관리자',
            'birth' => now(),
            'gender' => 'god',
            'activated' => '1',
        ]);

        factory(App\User::class, 30)->create();
    }
}
=======
<?php	
use Illuminate\Database\Seeder;	
class UsersTableSeeder extends Seeder	
{	
    /**	
     * Run the database seeds.	
     *	
     * @return void	
     */	
    public function run()	
    {	
        App\User::create([	
            'rank' => 'A',	
            'email' => 'root@oomori.org',	
            'password' => bcrypt('oomori'),	
            'name' => '관리자',	
            'birth' => now(),	
            'gender' => 'god',	
            'activated' => '1',	
        ]);	
        factory(App\User::class, 30)->create();	
    }	
}
>>>>>>> c8a16b55ba50dc49170bea8741173f67b3b67ab5
