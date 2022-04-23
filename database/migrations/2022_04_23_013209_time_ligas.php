<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TimeLigas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_ligas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_liga');
            $table->unsignedBigInteger('id_time');
            $table->integer('pontos')->nullable()->default(null);
            $table->integer('vitorias')->nullable()->default(null);
            $table->integer('derrotas')->nullable()->default(null);
            $table->integer('empates')->nullable()->default(null);
        });

        Schema::table('time_ligas', function (Blueprint $table) {
            $table->foreign('id_liga')->references('id')->on('ligas')->onDelete('cascade');
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
        Schema::dropIfExists('time_ligas');
    }
}
