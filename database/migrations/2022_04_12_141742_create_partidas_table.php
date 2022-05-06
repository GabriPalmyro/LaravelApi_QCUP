<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_liga')->unsigned();
            $table->string('modo')->nullable();
            $table->string('jogo');
            $table->date('data');
            $table->string('link')->nullable()->default('');
            $table->timestamps();
        });

        Schema::table('partidas', function (Blueprint $table) {
            $table->foreign('id_liga')
                ->references('id')->on('ligas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partidas');
    }
}
