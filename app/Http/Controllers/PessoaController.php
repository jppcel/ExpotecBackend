<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Importado o arquivo Util para uso
use App\Http\Util\Util;

use App\Pessoa;

class PessoaController extends Controller
{
    public static function verifyLogin($cpf, $token){
      $validator = \Validator::make(["cpf" => $cpf, "token" => $token], [
        'cpf' => 'required|cpf',
        'token' => 'required',
      ]);
      // Se a validação falha, retorna um JSON de erro
      if($validator->fails()){
        return false;
      }else{
        $CPF = Util::CPFNumbers($cpf);
        $pessoa = Pessoa::where(["Cpf" => $CPF, "remember_token" => $token])->get();
        if(count($pessoa) == 1){
          return true;
        }else{
          return false;
        }
      }
    }
}
