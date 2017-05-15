<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

// Importado o arquivo Util para uso
use App\Http\Util\Util;

// Importando os Models que serão utilizados nesse controller
use App\Pessoa;
use App\Cidade;
use App\Estado;
use App\Pais;
use App\CEP;
use App\Mail\SendActivationLink;

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
   *  @param  string  cidade [7] => Cod_IBGE of the Person's City
   *  @param  string  telefone1 [11] => Phone 1 of Person
   *  @param  string  telefone2 [0 || 11] => Phone 2 of Person (nullable)
   *  @param  string  instituicao [0-100] => College of Person (nullable)
   *  @param  string  curso [0-50] => Course of Person (nullable)
   *  @param  int alunoUnivel [1] => If is AlunoUnivel of Person (nullable)
   */
  public function postNew(Request $request){

    // Faz a validação dos dados
    $validator = \Validator::make($request->all(), [
      'nome' => 'required|string|min:5|max:60',
      'cpf' => 'required|cpf|min:14|max:14|unique:Pessoa,Cpf',
      'email' => 'required|string|min:5|max:100|unique:Pessoa,Email',
      'cep' => 'required|string|min:8|max:9',
      'logradouro' => 'required|string|max:100',
      'numero' => 'nullable|string|max:5',
      'bairro' => 'nullable|string|max:40',
      'cidade' => 'required|integer|min:1000000|max:9999999',
      'telefone1' => 'required|string|min:11|max:11',
      'telefone2' => 'nullable|string|min:11|max:11',
      'instituicao' => 'nullable|string|max:100',
      'curso' => 'nullable|string|max:50',
      'alunoUnivel' => 'required|integer|min:1|max:1'
    ]);
    // Se a validação falha, retorna um JSON de erro
    if($validator->fails()){
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.0", "errors" => $validator->errors()), 422);
    }else{
      $CPF = Util::CPFNumbers($request->input("cpf"));
      $CEP = Util::CEPNumbers($request->input("cep"));
      if($CEP){
        // Agora confere se a cidade informada existe
        $cidades = Cidade::find($request->input("cidade"));
        if(count($cidades) == 1){
          $pessoa = new Pessoa;
          $pessoa->Cidade_Cod_Ibge = $request->input("cidade");
          $pessoa->Nome = $request->input("nome");
          $pessoa->Cpf = $CPF;
          $pessoa->Logradouro = $request->input("logradouro");
          $pessoa->NumEndereco = $request->input("numero");
          $pessoa->Bairro = $request->input("bairro");
          $pessoa->Cep = $CEP;
          $pessoa->Fone1 = $request->input("telefone1");
          $pessoa->Fone2 = ($request->input("telefone2")) ? $request->input("telefone2") : NULL;
          $pessoa->Email = $request->input("email");
          if($request->input("alunoUnivel") == 0){
            $pessoa->Instituicao = $request->input("instituicao");
            $pessoa->Curso = $request->input("curso");
          }
          $pessoa->AlunoUnivel = $request->input("alunoUnivel");
          $pessoa->remember_token = sha1($request->input("cpf") . date("YmdHis"));
          $pessoa->save();
          Mail::send('mail.ActivationLink', ["link" => env("APP_URL")."/token/".$pessoa->id."/".$pessoa->remember_token], function($message) use ($pessoa){
            $message->to($pessoa->Email, $pessoa->Nome)->subject('Cadastro realizado na Expotec - Necessita ativação.');
          });
          return response()->json(array("ok" => 1));
        }else{
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.1", "message" => "A cidade informada não existe."));
        }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.2", "message" => "O CEP não foi informado."));

      }
    }
  }


  /**
   *  @route: /api/web/inscricao/pessoa/{id}/{token}
   *
   *  @method: Get
   */
  public function getPessoa($id, $token){
    $pessoa = Pessoa::find($id);
    if($pessoa){
      if($pessoa->remember_token == $token){
        return response()->json(array("ok" => 1, "nome" => $pessoa->Nome));
      }else {
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.1", "message" => "O token informado não é válido."));
      }
    }else{
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.2", "message" => "O usuário informado não existe."));
    }
  }


  /**
   *  @route: /api/web/inscricao/activate
   *
   *  @method: Post
   *
   *  @param  string  senha [8-60] => Password
   *  @param  string  senha_confirmation [8-60] => Password confirmation
   */
  public function activateInscricao(Request $request){
    $pessoa = Pessoa::find($request->input("id"));
    if($pessoa){
      if($pessoa->remember_token == $request->input("token") && $pessoa->Senha == NULL){
        // Faz a validação dos dados
        $validator = \Validator::make($request->all(), [
          'senha' => 'required|string|min:8|max:60|confirmed'
        ]);
        // Se a validação falha, retorna um json de erro
        if($validator->fails()){
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.0", "errors" => $validator->errors()), 422);
        }else{
          $pessoa->Senha = bcrypt($request->input("senha"));
          $pessoa->remember_token = sha1($pessoa->cpf . date("YmdHis"));
          $pessoa->save();
          return response()->json(array("ok" => 1, "token" => $pessoa->remember_token));
        }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.1", "message" => "Um erro inesperado aconteceu."));
      }
    }else{
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.2", "message" => "O usuário informado não existe."));
    }
  }
}
