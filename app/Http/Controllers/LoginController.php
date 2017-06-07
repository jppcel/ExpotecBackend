<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Importado o arquivo Util para uso
use App\Http\Util\Util;

// Importando os Models que serão utilizados nesse controller
use App\Person;

use Hash;

class LoginController extends Controller
{
  /**
   *  @route /api/web/login
   *  @method Post
   *  @param  string  document [11 | 14] => CPF of Person
   *  @param  string  password [8-60] => Password of Person
   *
   */
    public static function toLogin(Request $request){
      $validator = \Validator::make($request->all(), [
        'document' => 'required|cpf',
        'password' => 'required|string|min:8|max:60'
      ]);
      // Se a validação falha, retorna um erro
      if($validator->fails()){
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.1", "message" => "CPF e/ou senha inválidos."), 422);
      }else{
        $CPF = Util::CPFNumbers($request->input("document"));
        $person = Person::where(["document" => $CPF])->first();
        if($person){
          $user = $person->user;
          if($user){
            if(Hash::check($request->input("password"), $user->password)){
              $user->remember_token = sha1($person->document . date("YmdHis"));
              $user->save();
              return response()->json(array("ok" => 1, "login" => 1, "token" => $user->remember_token));
            }else{
              return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.2", "message" => "CPF e/ou senha inválidos."), 422);
            }
          }else{
            return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.3", "message" => "CPF e/ou senha inválidos."), 422);
          }
        }else{
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.4", "message" => "CPF e/ou senha inválidos."), 422);
        }
      }
    }

    /**
     *  @route /api/web/logout
     *  @method Post
     *  @param  string  document [11 | 14] => CPF of Person
     *  @param  string  token => Token of this session
     */
      public static function toLogout(Request $request){
        $validator = \Validator::make($request->all(), [
          'document' => 'required|cpf',
          'token' => 'required|string'
        ]);
        // Se a validação falha, retorna um erro
        if($validator->fails()){
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.1", "message" => "Sessão inválida."), 422);
        }else{
          self::logout($request->input("document"), $request->input("token"));
        }
      }

      /**
       *  Dont have route!
       *  @param  string  cpf [14] => CPF of Person
       *  @param  string  token => Token of this session
       *  @param  string  returnType => Return type of the function, 0 for boolean and 1 for json
       */
      public static function logout($cpf, $token, $returnType = 1){
        $CPF = Util::CPFNumbers($cpf);
        $person = Person::where(["document" => $CPF])->first();
        if($person){
          $user = $person->user;
          if($user){
            if($user->remember_token == $token){
              $user->remember_token = sha1($user->person->document . date("YmdHis"));
              $user->save();
              if($returnType == 1){
                return response()->json(array("ok" => 1, "logout" => 1));
              }else{
                return true;
              }
            }else{
              if($returnType == 1){
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.2", "message" => "Sessão inválida."), 422);
              }else{
                return false;
              }
            }
          }
        }
      }
}
