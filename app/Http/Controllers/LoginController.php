<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

// Importado o arquivo Util para uso
use App\Http\Util\Util;

// Importando os Models que serão utilizados nesse controller
use App\Person;
use App\ResetPassword;

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
              if($user->is_active == 1){
                $user->remember_token = sha1($person->document . date("YmdHis"));
                $user->save();
                return response()->json(array("ok" => 1, "login" => 1, "token" => $user->remember_token));
              }else{
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.2", "message" => "O usuário não está ativo."), 422);
              }
            }else{
              return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.3", "message" => "CPF e/ou senha inválidos."), 422);
            }
          }else{
            return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.4", "message" => "CPF e/ou senha inválidos."), 422);
          }
        }else{
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.5", "message" => "CPF e/ou senha inválidos."), 422);
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

      public static function login($document, $password){
        $CPF = Util::CPFNumbers($document);
        $person = Person::where(["document" => $CPF])->first();
        if($person){
          $user = $person->user;
          if($user){
            if(Hash::check($password, $user->password)){
              if($user->is_active == 1){
                $user->remember_token = sha1($person->document . date("YmdHis"));
                $user->save();
                return array("ok" => 1, "login" => 1, "token" => $user->remember_token);
              }else{
                return array("ok" => 0, "error" => 1, "typeError" => "0.2", "message" => "O usuário não está ativo.");
              }
            }else{
              return array("ok" => 0, "error" => 1, "typeError" => "0.3", "message" => "CPF e/ou senha inválidos.");
            }
          }else{
            return array("ok" => 0, "error" => 1, "typeError" => "0.4", "message" => "CPF e/ou senha inválidos.");
          }
        }else{
          return array("ok" => 0, "error" => 1, "typeError" => "0.5", "message" => "CPF e/ou senha inválidos.");
        }
      }


    /**
     *  @route /api/mobile/login
     *  @method Post
     *  @param  string  document [11 | 14] => CPF of Person
     *  @param  string  password [8-60] => Password of Person
     *
     */
      public static function toLoginMobile(Request $request){
        $validator = \Validator::make($request->all(), [
          'document' => 'required|cpf',
          'password' => 'required|string|min:8|max:60'
        ]);
        // Se a validação falha, retorna um erro
        $CPF = Util::CPFNumbers($request->input("document"));
        if($validator->fails()){
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.1", "message" => "CPF e/ou senha inválidos."), 422);
        }else{
          return response()->json(LoginController::login($CPF, $request->input("password")));
        }
      }


      /**
       *  @route /api/mobile/logout
       *  @method Post
       *  @param  string  document [11 | 14] => CPF of Person
       *  @param  string  token => Token of this session
       */
        public static function toLogoutMobile(Request $request){
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
       *  @route /api/web/request_reset_password
       *  @method Post
       *  @param  string  document [11 | 14] => CPF of Person
       */
      public function askNewPassword(Request $request){
        $CPF = Util::CPFNumbers($request->input("document"));
        $person = Person::where(["document" => $CPF])->first();
        if($person){
          $resetPassword = new ResetPassword;
          $resetPassword->Person_id = $person->id;
          $resetPassword->token = sha1($person->document . date("YmdHis"));
          $resetPassword->save();
          Mail::send('mail.ResetPassword', ["link" => env("APP_URL_FRONT")."/reset_password/".$person->id."/".$resetPassword->token], function($message) use ($person){
            $message->to($person->email, $person->name)->subject(env("APP_NAME").' - Solicitação de nova senha');
          });
          return response()->json(array("ok" => 1));
        }else{
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "7.1", "message" => "Usuário não encontrado."), 422);
        }
      }


      /**
       *  @route /api/web/reset_password
       *  @method Post
       *  @param  string  id => id of Person
       *  @param  string  token => token of Request
       *  @param  string  password  [8-60] => new password
       *  @param  string  password_confirmation  [8-60] => new password confirmation
       */
      public function setNewPassword(Request $request){
        $person = Person::find($request->input("id"));
        if($person){
          $resetPassword = ResetPassword::where([["Person_id", "=", $person->id],["token", "=", $request->input("token")]])->first();
          if($resetPassword && $person->user->is_active == 1){
            if(strtotime($resetPassword->created_at)+(60*60*24) > time() && $resetPassword->is_used == 0){
              // Faz a validação dos dados
              $validator = \Validator::make($request->all(), [
                'password' => 'required|string|min:8|max:60|confirmed'
              ]);
              // Se a validação falha, retorna um json de erro
              if($validator->fails()){
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.0", "errors" => $validator->errors()), 422);
              }else{
                $person->user->password = bcrypt($request->input("password"));
                $person->user->remember_token = sha1($person->document . date("YmdHis"));
                $person->user->is_active = 1;
                $person->user->save();

                $resetPassword->is_used = 1;
                $resetPassword->save();
                return response()->json(array("ok" => 1));
              }
            }else{
              return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.1", "message" => "O link está expirado ou é inválido."), 422);
            }
          }else{
            return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.2", "message" => "O link está expirado ou é inválido."), 422);
          }
        }else{
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.3", "message" => "O usuário não existe."), 404);
        }
      }

      /**
       *  Method Util: Verify login | Don't have route!
       *  @param  string  cpf [14] => CPF of Person
       *  @param  string  token => Token of this session
       *
       */
        public static function verifyLogin($cpf, $token, $type = 1){
          $validator = \Validator::make(["cpf" => $cpf, "token" => $token], [
            'cpf' => 'required|cpf',
            'token' => 'required',
          ]);
          // Se a validação falha, retorna falso

          if($type == 1){
            $limitTime = 900;
          }else{
            $limitTime = 60*60*24;
          }

          $retorno = false;
          if(!$validator->fails()){
            $CPF = Util::CPFNumbers($cpf);
            $person = Person::where(["document" => $CPF])->first();
            if($person){
              $user = $person->user;
              if($user->remember_token == $token){
                if($user->is_active == 1){
                  if($user->updated_at > date("Y-m-d H:i:s",time()-$limitTime)){
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
