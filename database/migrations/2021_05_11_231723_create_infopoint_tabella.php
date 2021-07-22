<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfopointTabella extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infopoint', function (Blueprint $table) {
            $table->id();
            $table->string('pathImage', 255)->nullable();
            $table->string('indirizzo', 255);
            $table->string('cap', 5);
            $table->string('responsabile', 60)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('denominazione', 120)->nullable();
            $table->string('numerotelefono', 20)->nullable();
            $table->integer('comune_id');
            $table->text('note')->nullable();
            $table->string('latitudine', 40);
            $table->string('longitudine', 40);
            $table->string('urlmappa', 255)->nullable();
            $table->string('frazione', 60)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infopoint');
    }
}
