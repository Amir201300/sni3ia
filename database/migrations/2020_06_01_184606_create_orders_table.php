<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location_lat')->nullable();
            $table->string('location_lng')->nullable();
            $table->string('location_address')->nullable();
            $table->string('destination_lat')->nullable();
            $table->string('destination_lng')->nullable();
            $table->string('destination_address')->nullable();
            $table->double('cost')->nullable();
            $table->integer('eta')->nullable();
            $table->smallInteger('status')->default(0)->nullable();
            $table->unsignedInteger('winch_id')->nullable();
            $table->foreign('winch_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
