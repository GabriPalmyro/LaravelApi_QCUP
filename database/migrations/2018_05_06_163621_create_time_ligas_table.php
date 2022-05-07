<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeLigasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('time_ligas');
        Schema::create('time_ligas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_time')->index();
            $table->unsignedBigInteger('id_liga')->index();
            $table->integer('pontos')->nullable()->default(0);
            $table->integer('vitorias')->nullable()->default(0);
            $table->integer('derrotas')->nullable()->default(0);
            $table->integer('empates')->nullable()->default(0);
            $table->timestamps();
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
