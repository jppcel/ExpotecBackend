<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PessoaController;
use App\Package;

class PacoteController extends Controller
{
  /**
   *  @route: /api/web/package/list
   *
   *  @method: Post
   *
   *  @param  string  document [11 | 14] => CPF of Person
   *  @param  string  token => Token of this session
   *
   */
    public function listAll(Request $request){
      if(PessoaController::verifyLogin($request->input("document"), $request->input("token"))){
        $packages = Package::all();
        $return = NULL;
        foreach($packages as $package){
          if($package->coupon == NULL){
            $array = array();
            $array["id"] = $package->id;
            $array["name"] = $package->name;
            $array["value"] = $package->value;
            $array["startDate"] = $package->startDate;
            $array["endDate"] = $package->endDate;
            $array["description"] = $package->description;
            $array["acceptSubscription"] = $this->verifyLimit($package->id);
            $return[] = $array;
          }
        }
        return response()->json(array("ok" => 1, "return" => $return));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }

    /**
     *  @route: /api/web/package/byCoupon
     *
     *  @method: Post
     *
     *  @param  string  document [11 | 14] => CPF of Person
     *  @param  string  token => Token of this session
     *  @param  string  coupon => coupon of package
     *
     */
   public function getPackageByCoupon(Request $request){
     if(PessoaController::verifyLogin($request->input("document"), $request->input("token"))){
       if($request->input("coupon")){
         $package = Package::where("coupon",$request->input("coupon"))->first();
         if($package){
           $return["id"] = $package->id;
           $return["name"] = $package->name;
           $return["value"] = $package->value;
           $return["startDate"] = $package->startDate;
           $return["endDate"] = $package->endDate;
           $return["description"] = $package->description;
           $return["acceptSubscription"] = $this->verifyLimit($package->id);
           return response()->json(array("ok" => 1, "return" => $return));
         }else{
           return response()->json(array("ok" => 0, "error" => 1, "typeError" => "11.1", "message" => "Pacote não encontrado."), 422);
         }
       }else{
         return response()->json(array("ok" => 0, "error" => 1, "typeError" => "11.2", "message" => "O código de cupom não foi informado."), 422);
       }
     }else{
       return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
     }
   }



    public static function verifyLimit($id){
      $package = Package::find($id);
      if($package){
        if(strtotime($package->endDate) > time()){
          $countSubs = 0;
          if($package->limit){
            foreach($package->subscriptions->all() as $subscription){
              if($subscription->payment){
                foreach($subscription->payment->all() as $payment){
                  if($payment->paymentStatus == 2 || $payment->paymentStatus == 3){
                    $countSubs++;
                  }
                }
              }
            }
            if($package->limit <= $countSubs){
              return false;
            }
          }
          return true;
        }else{
          return false;
        }
      }else{
        return 0;
      }
    }
}
