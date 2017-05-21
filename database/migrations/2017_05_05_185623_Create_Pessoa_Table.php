<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Pessoa', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Cidade_Cod_Ibge")->unsigned();
          $table->string("Nome", 60);
          $table->string("Cpf", 11);
          $table->string("Logradouro", 100);
          $table->string("NumEndereco", 5)->nullable();
          $table->string("Bairro", 40)->nullable();
          $table->string("Cep", 8);
          $table->string("Fone1", 11);
          $table->string("Fone2", 11)->nullable();
          $table->string("Email", 100);
          $table->string("Curso", 50)->nullable();
          $table->string("Instituicao", 100)->nullable();
          $table->string("Senha", 60)->nullable();
          $table->boolean("AlunoUnivel");
          $table->datetime("lastLogin")->nullable();
          $table->rememberToken();
          $table->timestamps();
          $table->foreign("Cidade_Cod_Ibge")->references("Cod_Ibge")->on("Cidade");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Pessoa');
    }
}
