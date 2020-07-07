<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar',110)->nullable();
            $table->string('name_en',110)->nullable();
            $table->text('desc_ar',110)->nullable();
            $table->text('desc_en',110)->nullable();
            $table->string('image',60)->nullable();
            $table->string('phone',110)->nullable();
            $table->string('sms',110)->nullable();
            $table->string('whatsapp',110)->nullable();
            $table->unsignedBigInteger('car_electration_id');
            $table->smallInteger('status')->default(0)->nullable();
            $table->foreign('car_slectration_id')->references('id')->on('car_electrations')->onDelete('cascade');
            $table->smallInteger('rate')->default(0)->nullable();
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
        Schema::dropIfExists('home_services');
    }
}
