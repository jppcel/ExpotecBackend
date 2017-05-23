<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PessoaController;
use App\Package;

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
        $packages = Package::all();
        $return = NULL;
        foreach($packages as $package){
          $array = array();
          $array["name"] = $package->name;
          $array["value"] = $package->value;
          $array["startDate"] = $package->startDate;
          $array["endDate"] = $package->endDate;
          $array["acceptSubscription"] = $this->verifyLimit($package->id);
          $return[] = $array;
        }
        return response()->json(array("ok" => 1, "return" => $return));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."));
      }
    }



    public static function verifyLimit($id){
      $package = Package::find($id);
      if($package){
        $limite = $package->endDate;
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
