<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\State;
use App\City;

class CityController extends Controller
{

    /**
     *  @route: /api/web/states
     *
     *  @method: Get
     */
    public function listStates(){
      $states = State::all();
      if(count($states) > 0){

      }
      return response()->json();
    }

      /**
       *  @route: /api/web/cities/{id}
       *
       *  @method: Get
       *
       *  @param: integer id => State id
       */
    public function listCities($state_id){
      $cities = City::where("State_id", $state_id)->get();
      if(count($cities) > 0){
        return response()->json();
      }else{
        return response()->json(array("ok" => 0), 404);
      }
    }
}
