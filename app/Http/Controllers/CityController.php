<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\State;
use App\City;

class CityController extends Controller
{
    public function listStates(){
      return response()->json(State::all());
    }
    public function listCities($state_id){
      return response()->json(City::where("State_id", $state_id)->get());
    }
}
