<?php

namespace App\Http\Util;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Util
{
  public static function CPFNumbers($cpf = ''){
    if(strlen($cpf) == 11){
      return $cpf;
    }else{
      $part1 = explode("-", $cpf);
      if(count($part1) == 2){
        $part2 = explode(".", $part1[0]);
        if(count($part2) == 3){
          $cpfNumbers = implode("",$part2) . $part1[1];
          return $cpfNumbers;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
  }

  public static function CEPNumbers($cep = ''){
    if(strlen($cep) == 8){
      return $cep;
    }else{
      if(strlen($cep) == 9){
        $cepParts = implode("",explode("-", $cep));
        return $cepParts;
      }else{
        return false;
      }
    }
  }

  public static function PhoneNumbers($phone, $thePhone = false){
    $Phone = explode(" ", $phone);
    if($thePhone){
      $return = implode("", explode("-", $Phone[1]));
    }else{
      $ddd = explode("(", $Phone[0]);
      $return = explode(")", $ddd[1])[0];
    }
    return $return;
  }
}
