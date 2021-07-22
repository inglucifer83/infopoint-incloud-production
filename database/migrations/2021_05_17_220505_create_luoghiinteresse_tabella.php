<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLuoghiinteresseTabella extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('luoghiinteresse', function (Blueprint $table) {
            $table->id();
            $table->string('pathImage', 255)->nullable();
            $table->string('pathFile', 255)->nullable();
            $table->unsignedInteger('comune_id');
            $table->unsignedInteger('tipoluoghiinteresse_id');
            $table->string('frazione', 60)->nullable();
            $table->string('indirizzo', 255);
            $table->string('latitudine', 40);
            $table->string('longitudine', 40);
            $table->string('denominazione', 255);
            $table->string('website', 255)->nullable();
            $table->string('responsabile', 60)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->text('descrizione')->nullable();
            $table->string('urlext', 255)->nullable();
            $table->string('urlmappa', 255)->nullable();
            $table->float('costobigliettoadulti')->nullable();
            $table->string('notecostobigliettoadulti', 255)->nullable();
            $table->float('costobigliettobambini')->nullable();
            $table->string('notecostobigliettobambini', 255)->nullable();
            $table->float('costobigliettoridotto')->nullable();
            $table->string('notecostobigliettoridotto', 255)->nullable();
            $table->text('notebiglietti', 255)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('luoghiinteresse');
    }
}
