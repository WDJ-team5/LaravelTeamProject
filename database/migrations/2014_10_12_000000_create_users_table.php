<<<<<<< HEAD
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rank')->default('C');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('birth');
            $table->string('gender');
            $table->rememberToken();
            $table->timestamps();
            $table->datetime('last_login')->nullable();
            $table->string('confirm_code', 60)->nullable();
            $table->string('activated')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
=======
<?php	
use Illuminate\Database\Migrations\Migration;	
use Illuminate\Database\Schema\Blueprint;	
use Illuminate\Support\Facades\Schema;	
class CreateUsersTable extends Migration	
{	
    /**	
     * Run the migrations.	
     *	
     * @return void	
     */	
    public function up()	
    {	
        Schema::create('users', function (Blueprint $table) {	
            $table->bigIncrements('id');	
            $table->string('rank')->default('C');	
            $table->string('email')->unique();	
            $table->string('password');	
            $table->string('name');	
            $table->string('birth');	
            $table->string('gender');	
            $table->rememberToken();	
            $table->timestamps();	
            $table->datetime('last_login')->nullable();	
            $table->string('confirm_code', 60)->nullable();	
            $table->string('activated')->default(0);	
        });	
    }	
    /**	
     * Reverse the migrations.	
     *	
     * @return void	
     */	
    public function down()	
    {	
        Schema::dropIfExists('users');	
    }	
}
>>>>>>> c8a16b55ba50dc49170bea8741173f67b3b67ab5
