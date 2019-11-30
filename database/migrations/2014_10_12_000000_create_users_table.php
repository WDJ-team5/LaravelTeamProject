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
            $table->string('hint');
            $table->string('answer');
            $table->rememberToken();
            $table->timestamps();
            $table->datetime('last_login')->nullable();
            $table->string('confirm_code', 60)->nullable();
            $table->boolean('activated')->default(0);
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
