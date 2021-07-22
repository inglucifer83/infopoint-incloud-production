<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComuniTabella extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void  
     */
    public function up()
    {
        Schema::create('comuni', function (Blueprint $table) {
            $table->id();
            $table->string('nomecomune', 50);
            $table->string('pathImage', 255)->nullable();
            $table->string('indirizzo', 255);
            $table->string('cap', 5);
            $table->string('responsabile', 60)->nullable();
            $table->string('numerotelefono', 20)->nullable();
            $table->string('urlmappa', 255)->nullable();
            $table->string('urlext', 255)->nullable();
            $table->text('descrizione')->nullable();
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
        Schema::dropIfExists('comuni');
    }
}
