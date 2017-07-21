<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;

class SubscriptionController extends Controller
{
    public function isPaid($id){
      $subscription = Subscription::find($id);
      foreach($subscription->payment->all() as $payment){
        if($payment->paymentStatus == 3){
          return true;
        }
      }
      return false;
    }
    public function havePermission($Subscription_id, $Activity_id){
      $subscription = Subscription::find($Subscription_id);
      if($subscription){
        foreach($subscription->package->tracks_package as $track_package){
          foreach($track_package->track->activities->all() as $activity){
            if($activity->id == $Activity_id){
              return true;
            }
          }
        }
      }
      return false;
    }
}
