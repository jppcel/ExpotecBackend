<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function listEvents(){
      $events = Event::all();
      $retorno = array();
      foreach($events as $event){
        $retorno[$event->attr] = $event->packages->all();
      }
      return response()->json($retorno);
    }
}
