<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar',110)->nullable();
            $table->string('name_en',110)->nullable();
            $table->text('desc_ar',110)->nullable();
            $table->text('desc_en',110)->nullable();
            $table->string('image',60)->nullable();
            $table->string('phone',110)->nullable();
            $table->string('sms',110)->nullable();
            $table->string('lat',110)->nullable();
            $table->string('lng',110)->nullable();
            $table->string('whatsapp',110)->nullable();
            $table->smallInteger('status')->default(0)->nullable();
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
        Schema::dropIfExists('live_services');
    }
}
