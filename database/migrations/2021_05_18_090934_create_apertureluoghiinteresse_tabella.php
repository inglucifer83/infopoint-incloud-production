<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApertureluoghiinteresseTabella extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apertureluoghiinteresse', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('luogointeresse_id');
            $table->unsignedInteger('giornosettimana_id');
            $table->time('orario_apertura');
            $table->time('orario_chiusura');
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
        Schema::dropIfExists('apertureluoghiinteresse');
    }
}
