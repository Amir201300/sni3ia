<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->smallInteger('status')->default(0)->nullable();
            $table->smallInteger('active')->default(0)->nullable();
            $table->smallInteger('verify')->default(0)->nullable();
            $table->smallInteger('rate')->default(0)->nullable();
            $table->enum('type',['user','winch']);
            $table->integer('code')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('lang',10)->nullable();
            $table->string('firebase_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
