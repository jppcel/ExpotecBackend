<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Estado;
use App\Cidade;

class CityController extends Controller
{
    public function listStates(){
      return response()->json(Estado::all());
    }
    public function listCities($state_id){
      return response()->json(Cidade::where("Estado_Id", $state_id)->get());
    }
}
