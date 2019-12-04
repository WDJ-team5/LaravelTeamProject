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
		App\User::create([	
            'rank' => 'B',	
            'email' => 'jhh9507@gmail.com',	
            'password' => bcrypt('1234'),	
            'name' => '장현호',	
            'birth' => '1993-02-17',
            'gender' => 'men',	
            'activated' => '1',	
        ]);
		
		App\User::create([	
            'rank' => 'B',	
            'email' => 'psjemailtest@gmail.com',	
            'password' => bcrypt('1234'),	
            'name' => '박수진',	
            'birth' => '1998-02-27',
            'gender' => 'men',	
            'activated' => '1',	
        ]);
		
		App\User::create([	
            'rank' => 'B',	
            'email' => 'hn04193@naver.com',	
            'password' => bcrypt('1234'),	
            'name' => '곽주훈',	
            'birth' => '1997-11-18',
            'gender' => 'men',	
            'activated' => '1',	
        ]);
		
		App\User::create([	
            'rank' => 'B',	
            'email' => 'dkslrjsl@gmail.com',	
            'password' => bcrypt('1234'),	
            'name' => '안희건',	
            'birth' => '1994-03-30',
            'gender' => 'men',	
            'activated' => '1',	
        ]);
		
		App\User::create([	
            'rank' => 'B',	
            'email' => 'dwg04045@gmail.com',	
            'password' => bcrypt('1234'),	
            'name' => '장성현',	
            'birth' => '1997-04-02',
            'gender' => 'men',	
            'activated' => '1',	
        ]);
		
		App\User::create([	
            'rank' => 'C',	
            'email' => 'r7042@naver.com',	
            'password' => bcrypt('1234'),	
            'name' => '이형철',	
            'birth' => '1993-11-10',
            'gender' => 'men',	
            'activated' => '1',	
        ]);
        factory(App\User::class, 30)->create();	
    }	
}