<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZIP;

// Importado o arquivo Util para uso
use App\Http\Util\Util;

class ZIPController extends Controller
{
    public function search($ZIP){
      $zip = ZIP::where('zipcode',Util::CEPNumbers($ZIP))->first();
      if(count($zip) == 1){
        $typeStreet = $zip->typeStreet;
        $city = $zip->city;
        $state = $city->state;
        $country = $state->country;
        $ZIP = array();
        $array = array();
        $array["ok"] = 1;

        if(count($typeStreet) > 0){
          $ZIP["typeStreet"] = array(
            "id" => $typeStreet->id,
            "name" => $typeStreet->name
          );
          $array["has"]["typestreet"] = 1;
        }else{
          $array["has"]["typestreet"] = 0;
        }

        if($zip->name){
          $ZIP["street"] = $zip->name;
          $array["has"]["street"] = 1;
        }else{
          $array["has"]["street"] = 0;
        }
        if($zip->neighborhood) {
          $ZIP["neighborhood"] = $zip->neighborhood;
          $array["has"]["neighborhood"] = 1;
        }else{
          $array["has"]["neighborhood"] = 0;
        }
        $ZIP["city"]["id"] = $city->id;
        $ZIP["city"]["name"] = $city->name;
        $ZIP["city"]["state"]["id"] = $state->id;
        $ZIP["city"]["state"]["name"] = $state->name;
        $ZIP["city"]["state"]["UF"] = $state->UF;
        $ZIP["city"]["state"]["country"]["id"] = $country->id;
        $ZIP["city"]["state"]["country"]["name"] = $country->name;

        $array["zip"] = $ZIP;
        return response()->json($array);
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "5.0", "message" => "CEP não encontrado."), 404);
      }
    }
}
