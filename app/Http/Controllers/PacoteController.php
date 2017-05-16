<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PessoaController;
use App\Pacote;

class PacoteController extends Controller
{
  /**
   *  @route: /api/web/pacote/list
   *
   *  @method: Post
   *
   *  @param  string  cpf [14] => CPF of Person
   *  @param  string  token => Token of this session
   *
   */
    public function listAll(Request $request){
      if(PessoaController::verifyLogin($request->input("cpf"), $request->input("token"))){
        $pacotes = Pacote::all();
        $retorno = NULL;
        foreach($pacotes as $pacote){
          $array = array();
          $array["nome"] = $pacote->nome;
          $array["valor"] = $pacote->valor;
          $array["dataLimite"] = $pacote->dataLimite;
          $array["aceitaInscricao"] = $this->verifyLimit($pacote->id);
          $retorno[] = $array;
        }
        return response()->json(array("ok" => 1, "return" => $retorno));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."));
      }
    }



    public static function verifyLimit($id){
      $pacote = Pacote::find($id);
      if($pacote){
        $limite = $pacote->dataLimite;
        if(strtotime($limite) > time()){
          return true;
        }else{
          return false;
        }
      }else{
        return 0;
      }
    }
}
