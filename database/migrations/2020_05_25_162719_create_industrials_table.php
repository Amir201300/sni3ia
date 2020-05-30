<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industrials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar',110)->nullable();
            $table->string('name_en',110)->nullable();
            $table->text('desc_ar',110)->nullable();
            $table->text('desc_en',110)->nullable();
            $table->string('image',60)->nullable();
            $table->string('phone',110)->nullable();
            $table->string('sms',110)->nullable();
            $table->string('whatsapp',110)->nullable();
            $table->unsignedBigInteger('car_model_id')->nullable();
            $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('set null');
            $table->unsignedBigInteger('workShop_id')->nullable();
            $table->foreign('workShop_id')->references('id')->on('workshop_types')->onDelete('set null');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('set null');
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
        Schema::dropIfExists('industrials');
    }
}
