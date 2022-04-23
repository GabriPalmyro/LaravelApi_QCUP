 <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateLigasTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('ligas', function (Blueprint $table) {
                $table->id();
                $table->string('nome', 150);
                $table->string('logo', 300);
                $table->string('jogo');
                $table->string('tipo');
                $table->date('data_inicio');
                $table->date('data_limite_insc');
                $table->unsignedBigInteger('id_time_vencedor')->nullable()->default(null);
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
            Schema::dropIfExists('ligas');
        }
    }
