<<<<<<< HEAD
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
=======
<?php	
use Illuminate\Database\Migrations\Migration;	
use Illuminate\Database\Schema\Blueprint;	
use Illuminate\Support\Facades\Schema;	
class CreatePasswordResetsTable extends Migration	
{	
    /**	
     * Run the migrations.	
     *	
     * @return void	
     */	
    public function up()	
    {	
        Schema::create('password_resets', function (Blueprint $table) {	
            $table->string('email')->index();	
            $table->string('token')->index();	
            $table->timestamp('created_at')->nullable();	
        });	
    }	
    /**	
     * Reverse the migrations.	
     *	
     * @return void	
     */	
    public function down()	
    {	
        Schema::dropIfExists('password_resets');	
    }	
}
>>>>>>> c8a16b55ba50dc49170bea8741173f67b3b67ab5
