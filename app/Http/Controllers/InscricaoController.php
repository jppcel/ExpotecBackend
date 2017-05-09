<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

// Importando os Models que serão utilizados nesse controller
use App\Pessoa;
use App\Cidade;
use App\Estado;
use App\Pais;

class InscricaoController extends Controller
{
  /**
   *  @route: /api/web/inscricao/new
   *
   *  @method: Post
   *  Atribbutes:
   *    Example: - attribute(type, [limits]) => description
   *    Limits:
   *      || => or;
   *      - interval.
   *
   *  @param  string  nome [5-60] => Name of Person
   *  @param  string  cpf [14] => CPF of Person
   *  @param  string  email [5-100] => Email of Person
   *  @param  string  cep [9] => ZIP Code of Person's Address
   *  @param  string  logradouro [0-100] => Address of Person's Address
   *  @param  integer numero [0-5] => number of Person's Address (nullable)
   *  @param  string  bairro [0-40] => zone of Person's Address (nullable)
   *  @param  string  cidade [1-100] => city of Person's Address
   *  @param  string  uf [2] => state of Person's Address
   *  @param  string  telefone1 [11] => Phone 1 of Person
   *  @param  string  telefone2 [0 || 11] => Phone 2 of Person (nullable)
   *  @param  string  instituicao [0-100] => College of Person (nullable)
   *  @param  string  curso [0-50] => Course of Person (nullable)
   *  @param  int alunoUnivel [1] => If is AlunoUnivel of Person (nullable)
   */
  public function postNew(Request $request){

    // Faz a validação dos dados
    // $this->validate($request, [
    //   'nome' => 'required|string|min:5|max:60',
    //   'cpf' => 'required|string|min:14|max:14|unique:Pessoa,Cpf',
    //   'email' => 'required|string|min:5|max:100',
    //   'cep' => 'required|string|min:9|max:9',
    //   'logradouro' => 'required|string|max:100',
    //   'numero' => 'string|max:5',
    //   'bairro' => 'string|max:40',
    //   'cidade' => 'required|string|min:1|max:100',
    //   'uf' => 'required|string|min:2|max:2',
    //   'telefone1' => 'required|string|min:11|max:11',
    //   'telefone2' => 'string|min:11|max:11',
    //   'instituicao' => 'string|max:100',
    //   'curso' => 'string|max:50',
    //   'alunoUnivel' => 'required|int|min:1|max:1'
    // ]);

    // Confere se o estado informado existe
    $estados = Estado::where("UF", strtoupper($request->input("uf")))->get();
    foreach($estados as $estado){

      // Agora confere se a cidade informada existe
      $cidades = Cidade::where([
        "Cidade" => strtoupper($request->input("cidade")),
        "Estado_Id" => $estado["Id"]
      ])->get();
      foreach($cidades as $cidade){
        $pessoa = new Pessoa;
        $pessoa->Cidade_Cod_Ibge = $cidade["Cod_Ibge"];
        $pessoa->Nome = $request->input("nome");
        $pessoa->Cpf = $request->input("cpf");
        $pessoa->Logradouro = $request->input("logradouro");
        $pessoa->NumEndereco = $request->input("numero");
        $pessoa->Bairro = $request->input("bairro");
        $pessoa->Cep = $request->input("cep");
        $pessoa->Fone1 = $request->input("telefone1");
        $pessoa->Fone2 = ($request->input("telefone2")) ? $request->input("telefone2") : NULL;
        $pessoa->Email = $request->input("email");
        if($request->input("alunoUnivel") == 0){
          $pessoa->Instituicao = $request->input("instituicao");
          $pessoa->Curso = $request->input("curso");
        }
        $pessoa->AlunoUnivel = $request->input("alunoUnivel");
        $pessoa->save();
      }
    }
  }
}
