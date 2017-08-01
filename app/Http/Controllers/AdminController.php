<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Permission;
use App\UserPermission;

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

    public function hasPermission($Permission_id){
      $permission = Permission::find($Permission_id);
      if($permission){
        $userPermission = UserPermission::where(["User_id" => $this->getPerson()->user->id, "Permission_id" => $Permission_id])->first();
        if($userPermission){
          return true;
        }
      }
      return false;
    }
}
