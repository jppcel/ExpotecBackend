<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PessoaController;
use App\Person;

class CartController extends Controller
{


/**
 *  @route: /api/web/subscription/cart/add
 *
 *  @method: Post
 *
 *  @param  string document => [14] id of Person
 *  @param  string token => token of this session
 *  @param  integer package_id => Pacote's Id
 */
  public function new(Request $request){
    $person = PessoaController::verifyLogin($request->input("document"), $request->input("token"));
    if($person){
      if($request->input("package_id")){
        $cart = Cart::where(["Person_id" => $person->id])->first();
        if($cart){
          $cart->delete();
          $cart = new Cart;
          $cart->Package_id = $request->input("package_id");
          $cart->Person_id = $person->id;
          $cart->save();
        }
      }
    }else{
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
    }
  }


  /**
   *  @route: /api/web/subscription/cart/delete
   *
   *  @method: Post
   *
   *  @param  string document => [14] id of Person
   *  @param  string token => token of this session
   */
    public function delete(Request $request){
      $person = PessoaController::verifyLogin($request->input("document"), $request->input("token"));
      if($person){
        if($request->input("package_id")){
          $cart = Cart::where(["Person_id" => $person->id])->first();
          if($cart){
            $cart->delete();
          }
        }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }


    /**
     *  @route: /api/web/subscription/cart/get
     *
     *  @method: Post
     *
     *  @param  string document => [14] id of Person
     *  @param  string token => token of this session
     */
      public function get(Request $request){
        $person = PessoaController::verifyLogin($request->input("document"), $request->input("token"));
        if($person){
          if($request->input("package_id")){
            $cart = Cart::where(["Person_id" => $person->id])->first();
            if($cart){
              $retorno["id"] = $cart->id;
              $retorno["Package"]["id"] = $cart->Package_id;
              $retorno["Package"]["nome"] = $cart->Package->name;
              $retorno["Package"]["description"] = $cart->Package->description;
              return rensponse()->json($retorno);
            }else{
              return response()->json(array("ok" => 0, "error" => 1, "typeError" => "5.1", "message" => "Não há carrinho."), 404);
            }
          }
        }else{
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
        }
      }
}
