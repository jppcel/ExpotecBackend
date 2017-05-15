<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Pagamento', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Pessoa_Inscricao_Pacote_id")->unsigned();
          $table->string("idTransacao");
          $table->integer("statusPagamento");
          $table->foreign("Pessoa_Inscricao_Pacote_id")->references("id")->on("Pessoa_Inscricao_Pacote");
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
        //
    }
}
