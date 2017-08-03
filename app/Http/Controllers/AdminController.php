<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LoginController;
use App\Permission;
use App\UserPermission;
use App\Person;

class AdminController extends Controller
{
    public function __construct(){
      if(session_status() == PHP_SESSION_NONE){
        session_start();
      }
    }
    public function login(){
      return view("painel.login");
    }

    public function logar(Request $request){
      if($request->input("document") && $request->input("password")){
        $loginController = new LoginController;
        $login = $loginController->login($request->input("document"), $request->input("password"));
        if($login["ok"] == 1){
          $_SESSION["document"] = $request->input("document");
          $_SESSION["token"] = $login["token"];
          Log::useFiles(base_path('storage/logs/admin-info.log'), 'info');
          Log::info('['.date("d/m/Y H:i:s").']');
          return redirect("/");
        }else{
          return redirect("/login");
        }
      }
    }

    public function verifyLogin(){
      if(isset($_SESSION["document"]) && isset($_SESSION["token"])){
        $loginController = new LoginController;
        $login = $loginController->verifyLogin($_SESSION["document"], $_SESSION["token"], 2);
        if(!$login){
          return false;
        }
        if($login->user->is_admin){
          return true;
        }else{
          return false;
        }
      }
    }

    public static function verifyLoginMobile($document, $token){
      if(isset($document) && isset($token)){
        $loginController = new LoginController;
        $login = $loginController->verifyLogin($document, $token, 2);
        if(!$login){
          return false;
        }
        if($login->user->is_admin){
          return true;
        }else{
          return false;
        }
      }
    }

    public static function getPerson(){
      if($_SESSION["document"] && $_SESSION["token"]){
        $loginController = new LoginController;
        $login = $loginController->verifyLogin($_SESSION["document"], $_SESSION["token"], 2);
        if(!$login){
          return false;
        }
        return $login;
      }
    }

    public function logout(){
      $_SESSION["document"] = NULL;
      $_SESSION["token"] = NULL;
      unset($_SESSION["document"]);
      unset($_SESSION["token"]);
      session_destroy();
      return redirect("/");
    }

    public function hasPermission($Permissions_id, $document, $token){
      if($this->verifyLogin()){
        foreach($Permissions_id as $Permission_id){
          $permission = Permission::find($Permission_id);
          if($permission){
            $userPermission = UserPermission::where(["User_id" => $this->getPerson()->user->id, "Permission_id" => $Permission_id])->first();
            if($userPermission){
              return true;
            }
          }
        }
      }
      return false;
    }

    public static function hasPermissionMobile($Permissions_id, Person $person, $document, $token){
      if(AdminController::verifyLoginMobile($document, $token)){
        foreach($Permissions_id as $Permission_id){
          $permission = Permission::find($Permission_id);
          if($permission){
            $userPermission = UserPermission::where(["User_id" => $person->user->id, "Permission_id" => $Permission_id])->first();
            if($userPermission){
              return true;
            }
          }
        }
      }
      return false;
    }
}
