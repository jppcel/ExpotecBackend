<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Importado o arquivo Util para uso
use App\Http\Util\Util;

use App\Pessoa;

class PessoaController extends Controller
{
  /**
   *  Method Util: Verify login | Don't have route!
   *  @param  string  cpf [14] => CPF of Person
   *  @param  string  token => Token of this session
   *
   */
    public static function verifyLogin($cpf, $token){
      $validator = \Validator::make(["cpf" => $cpf, "token" => $token], [
        'cpf' => 'required|cpf',
        'token' => 'required',
      ]);
      // Se a validação falha, retorna falso
      $retorno = false;
      if(!$validator->fails()){
        $CPF = Util::CPFNumbers($cpf);
        $pessoa = Pessoa::where(["Cpf" => $CPF, "remember_token" => $token])->get();
        foreach($pessoa as $Pessoa){
          if($Pessoa->remember_token == $token){,
            if($Pessoa->updated_at < time()-900){
                $retorno = true;
            }else{
              LoginController::logout($cpf, $token, 0);
            }
          }
        }
      }
      return $retorno;
    }
}
