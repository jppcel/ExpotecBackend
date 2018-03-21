<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Log;

class LogController extends Controller
{
    public static function make($text, $type = 1){
      $adminController = new AdminController;
      if($type == 1){
        if($adminController->verifylogin()){
          $log = new Log;
          $log->User_id = $adminController->getPerson()->user->id;
          $log->text = "[".date("d/m/Y H:i:s")."]: ".$text;
          $log->type = $type;
          $log->save();
        }
      }elseif($type == 2){
        if(env("APP_SUBSCRIPTION_LOG",false)){
          $log = new Log;
          $log->text = "[".date("d/m/Y H:i:s")."]: ".$text;
          $log->type = $type;
          $log->save();
        }
      }
    }
}
