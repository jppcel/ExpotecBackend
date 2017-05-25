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
      return response()->json(State::all());
    }

      /**
       *  @route: /api/web/cities/{id}
       *
       *  @method: Get
       *
       *  @param: integer id => State id
       */
    public function listCities($state_id){
      return response()->json(City::where("State_id", $state_id)->get());
    }
}
