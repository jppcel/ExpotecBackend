<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Log;

class LogController extends Controller
{
    public static function make($text){
      $adminController = new AdminController;
      if($adminController->verifylogin()){
        $log = new Log;
        $log->User_id = $adminController->getPerson()->user->id;
        $log->text = "[".date("d/m/Y H:i:s")."]: ".$text;
        $log->save();
      }
    }
}
