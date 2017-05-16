<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PessoaController;
use App\Trilha;

class TrilhaController extends Controller
{

    /**
     *  @route: /api/web/trilha/list
     *
     *  @method: Post
     *
     *  @param  string  cpf [14] => CPF of Person
     *  @param  string  token => Token of this session
     *
     */
    public function listAll(Request $request){
      if(PessoaController::verifyLogin($request->input("cpf"), $request->input("token"))){
        $trilhas = Trilha::all();
        $retorno = NULL;
        foreach($trilhas as $trilha){
          $array = array();
          $array["nome"] = $trilha->nome;
          $array["diaInicio"] = $trilha->diaInicio;
          $array["diaFim"] = $trilha->diaFim;
          $array["aceitaInscricao"] = $this->verifyLimit($trilha->id);
          $array["vagas"] = $trilha->vagas;
          $atividades = array();
          foreach($trilha->atividades->all() as $atividade){
            $atividade_add = array();
            $atividade_add["id"] = $atividade->id;
            $atividade_add["nome"] = $atividade->nome;
            $atividade_add["palestrante"] = $atividade->palestrante;
            $atividade_add["dataInicio"] = $atividade->dataInicio;
            $atividade_add["dataFim"] = $atividade->dataFim;
            $atividades[] = $atividade_add;
          }
          $array["atividades"] = $atividades;
          $retorno[] = $array;
        }
        return response()->json(array("ok" => 1, "return" => $retorno));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."));
      }
    }

    public static function verifyLimit($id){
      $trilha = Trilha::find($id);
      if($trilha){
        $limite = $trilha->vagas;
        if($limite > 0 || $limite == NULL){
          return true;
        }else{
          return false;
        }
      }else{
        return 0;
      }
    }
}
