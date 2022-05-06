<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimePartidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_partidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_time')->index();
            $table->unsignedBigInteger('id_partida')->index();
            $table->integer('pontuacao')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('time_partidas', function (Blueprint $table) {
            $table->foreign('id_partida')->references('id')->on('partidas')->onDelete('cascade');
            $table->foreign('id_time')->references('id')->on('times')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_partidas');
    }
}
