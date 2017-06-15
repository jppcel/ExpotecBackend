<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeStreet;

class AddressController extends Controller
{
    public function listTypeStreet(){
      $typeStreet = TypeStreet::all();
      return response()->json($typeStreet);
    }
}
