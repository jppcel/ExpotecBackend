<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PessoaController;
use App\Event;

class EventController extends Controller
{
    public function listEvents(Request $request){
      $person = PessoaController::verifyLogin($request->input("document"), $request->input("token"));
      if($person){
        $events = Event::all();
        $retorno = array();
        foreach($events as $event){
          $retorno[$event->attr] = $event->packages->all();
        }
        return response()->json($retorno);
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }
}
