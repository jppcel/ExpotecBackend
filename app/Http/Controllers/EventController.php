<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PacoteController;
use App\Event;

class EventController extends Controller
{
    public function listEvents(Request $request){
      $person = PessoaController::verifyLogin($request->input("document"), $request->input("token"));
      if($person){
        $events = Event::all();
        $retorno = array();
        foreach($events as $event){
          foreach($event->packages->all() as $package){
            if($package->coupon == NULL){
              $array = array();
              $array["id"] = $package->id;
              $array["name"] = $package->name;
              $array["value"] = $package->value;
              $array["startDate"] = $package->startDate;
              $array["endDate"] = $package->endDate;
              $array["description"] = $package->description;
              $array["acceptSubscription"] = PacoteController::verifyLimit($package->id);
              $retorno[$event->attr][] = $array;
            }
          }
        }
        return response()->json($retorno);
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }
}
