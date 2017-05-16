<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  /**
   *  @route /api/web/login
   *  @method Post
   *  @param  string  cpf [14] => CPF of Person
   *  @param  string  password [8-60] => Password of Person
   *
   */
    public static function toLogin(Request $request){
      $validator = \Validator::make($request->all(), [
        'cpf' => 'required|cpf',
        'password' => 'required|string|min:8|max:60'
      ]);
      // Se a validação falha, retorna um erro
      if($validator->fails()){
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.1", "message" => "CPF e/ou senha inválidos."));
      }else{
        $CPF = Util::CPFNumbers($request->input("cpf"));
        $pessoa = Pessoa::where(["Cpf" => $CPF])->get();
        foreach($pessoa as $Pessoa){
          if($Pessoa->password == bcrypt($request->input("password"))){
            $Pessoa->remember_token = sha1($pessoa->cpf . date("YmdHis"));
            $Pessoa->save();
            return response()->json(array("ok" => 1, "login" => 1, "token" => $Pessoa->remember_token));
          }else{
            return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.2", "message" => "CPF e/ou senha inválidos."));
          }
        }
      }
    }

    /**
     *  @route /api/web/logout
     *  @method Get ou Post
     *  @param  string  cpf [14] => CPF of Person
     *  @param  string  token => Token of this session
     */
      public static function toLogout(Request $request){
        $validator = \Validator::make($request->all(), [
          'cpf' => 'required|cpf',
          'token' => 'required|string'
        ]);
        // Se a validação falha, retorna um erro
        if($validator->fails()){
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.1", "message" => "Sessão inválida."));
        }else{
          self::logout($request->input("cpf"), $request->input("token"));
        }
      }

      /**
       *  Dont have route!
       *  @param  string  cpf [14] => CPF of Person
       *  @param  string  token => Token of this session
       *  @param  string  returnType => Return type of the function, 0 for boolean and 1 for json
       */
      public static function logout($cpf, $token, $returnType = 1){
        $CPF = Util::CPFNumbers($request->input("cpf"));
        $pessoa = Pessoa::where(["Cpf" => $CPF])->get();
        foreach($pessoa as $Pessoa){
          if($Pessoa->password == bcrypt($request->input("password"))){
            $Pessoa->remember_token = sha1($pessoa->cpf . date("YmdHis"));
            $Pessoa->save();
            if($returnType == 1){
              return response()->json(array("ok" => 1, "logout" => 1));
            }else{
              return true;
            }
          }else{
            if($returnType == 1){
              return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.2", "message" => "Sessão inválida."));
            }else{
              return false;
            }
          }
        }
      }
}
