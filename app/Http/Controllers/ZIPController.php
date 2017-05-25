<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZIP;

class ZIPController extends Controller
{
    public function search($ZIP){
      $zip = ZIP::where('zipcode',$ZIP)->first();
      if(count($zip) == 1){
        $typeStreet = $zip->typeStreet;
        $city = $zip->city;
        $state = $city->state;
        $country = $state->country;
        return response()->json(array(
          "ok" => 1,
          "zip" => array(
            "type_street" => array(
              "id" => $typeStreet->id,
              "name" => $typeStreet->name
            ),
            "street" => $zip->name,
            "neighborhood" => $zip->neighborhood,
            "city" => array(
              "id" => $city->id,
              "name" => $city->name,
              "state" => array(
                "id" => $state->id,
                "name" => $state->name,
                "UF" => $state->UF,
                "country" => array(
                  "id" => $country->id,
                  "name" => $country->name
                )
              )
            )
          )
        ));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "5.0", "message" => "CEP não encontrado."));
      }
    }
}
