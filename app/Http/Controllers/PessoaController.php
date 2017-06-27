<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Importado o arquivo Util para uso
use App\Http\Util\Util;

use App\Person;

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
        $person = Person::where(["document" => $CPF])->first();
        if($person){
          $user = $person->user;
          if($user->remember_token == $token){
            if($user->is_active == 1){
              if($user->updated_at > date("Y-m-d H:i:s",time()-900)){
                $retorno = $user->person;
                $user->save();
              }else{
                LoginController::logout($cpf, $token, 0);
              }
            }
          }
        }
      }
      return $retorno;
    }
}
