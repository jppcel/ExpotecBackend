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
        $ZIP = array();
        if(count($typeStreet) > 0){
          $ZIP["typeStreet"] = array(
            "id" => $typeStreet->id,
            "name" => $typeStreet->name
          );
        }
        if($zip->name){ $ZIP["street"] = $zip->name; }
        if($zip->neighborhood) { $ZIP["neighborhood"] = $zip->neighborhood; }
        $ZIP["city"]["id"] = $city->id;
        $ZIP["city"]["name"] = $city->name;
        $ZIP["city"]["state"]["id"] = $state->id;
        $ZIP["city"]["state"]["name"] = $state->name;
        $ZIP["city"]["state"]["UF"] = $state->UF;
        $ZIP["city"]["state"]["country"]["id"] = $country->id;
        $ZIP["city"]["state"]["country"]["name"] = $country->name;
        return response()->json(array(
          "ok" => 1,
          "zip" => $ZIP
        ));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "5.0", "message" => "CEP não encontrado."));
      }
    }
}
