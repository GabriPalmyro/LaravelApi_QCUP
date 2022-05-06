<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJogadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_time')->unsigned();
            $table->string('nome', 150);
            $table->string('nickname', 80);
            $table->string('email', 100);
            $table->string('funcao', 180)->default('');
            $table->integer('kills')->nullable()->default(0);
            $table->integer('deaths')->nullable()->default(0);
            $table->integer('assists')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('jogadores', function (Blueprint $table) {

            $table->foreign('id_time')
                ->references('id')->on('times')
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
        Schema::dropIfExists('jogadores');
    }
}
