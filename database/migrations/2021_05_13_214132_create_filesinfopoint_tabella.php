<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesinfopointTabella extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filesinfopoint', function (Blueprint $table) {
            $table->id();
            $table->string('nomeFile', 255);
            $table->string('pathFile', 255);
            $table->string('estensioneFile', 10);
            $table->text('descrizioneFile')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('gruppo_id');
            $table->unsignedInteger('comune_id');
            $table->unsignedInteger('infopoint_id');
            $table->unsignedInteger('livelloaccesso_id');
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
        Schema::dropIfExists('filesinfopoint');
    }
}
