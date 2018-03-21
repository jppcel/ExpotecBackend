<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;
use App\Check;
use App\Event;
use App\Subscription;
use App\Activity;

class CheckController extends Controller
{


  private $typeCheck = array(1 => 'in', 2 => 'out');
    /*
     *  @route: /api/mobile/events
     *
     *  @method: Get
     */
     public function getEvents(Request $request){
       $person = PessoaController::verifyLoginMobile($request->input("document"), $request->input("token"));
       if($person){
         $events = Event::all();
         $return = array();
         foreach($events as $event){
           $retorno["id"] = $event->id;
           $retorno["name"] = $event->name;
           $retorno["activities"] = $event->activities->all();
           $return[$event->name] = $retorno;
         }
         return response()->json(array("events" => $return));
       }else{
         return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 401);
       }
     }

     /*
      *  @route: /api/mobile/events/subscriptions
      *
      *  @method: Post
      *
      *  @param: integer Activity_id => Activity id
      */
      public function getSubscriptions(Request $request){
        $person = PessoaController::verifyLoginMobile($request->input("document"), $request->input("token"));
        if($person){
          $activity = Activity::find($request->input("Activity_id"));
          if($activity){
            $subscribers = array();
            foreach($activity->track->track_package->all() as $track_package){
              foreach($track_package->package->subscriptions->all() as $subscriber){
                foreach($subscriber->payment->all() as $payment){
                  if($payment->paymentStatus == 3){
                    $subscribers[] = array($subscriber->id,$subscriber->person->name);
                  }
                }
              }
            }
            return response()->json(array("subscribers" => $subscribers));
          }
        }else{
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 401);
        }
      }

      /*
       *  @route: /api/mobile/check/new
       *
       *  @method: Post
       *
       *  @param: integer Activity_id => Activity id
       *  @param: integer Subscription_id => Subscription id
       *  @param: integer type => Type of check: 1 for in, 2 for out
       */
       public function newCheck(Request $request){
         $person = PessoaController::verifyLoginMobile($request->input("document"), $request->input("token"));
         if($person){
           $activity = Activity::find($request->input("Activity_id"));
           if($activity){
             $subscription = Subscription::find($request->input("Subscription_id"));
             if($subscription){
               $subscriptionController = new SubscriptionController;
               if($subscriptionController->isPaid($request->input("Subscription_id"))){
                 if($subscriptionController->havePermission($request->input("Subscription_id"), $request->input("Activity_id"))){
                   if(!empty($request->input("type"))){
                     $check = new Check;
                     $check->type = $this->typeCheck[$request->input("type")];
                     $check->User_id = $person->user->id;
                     $check->Subscription_id = $request->input("Subscription_id");
                     $check->Activity_id = $request->input("Activity_id");
                     $check->checked_at = date("Y-m-d H:i:s");
                     $check->save();
                     return response()->json(array("ok" => 1));
                   }else{
                     return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.1", "message" => "É necessário selecionar qual é o tipo de registro que deseja realizar: check-in ou check-out."));
                   }
                 }else{
                   return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.2", "message" => "A inscrição informada não tem acesso a essa atividade."));
                 }
               }else{
                 return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.3", "message" => "A inscrição informada não está confirmada."));
               }
             }else{
               return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.4", "message" => "A inscrição informada não existe."));
             }
           }else{
             return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.5", "message" => "A atividade informada não existe."));
           }
         }else{
           return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 401);
         }
       }



       /*
        *  @route: /api/mobile/check/new/panel
        *
        *  @method: Post
        *
        *  @param: integer Activity_id => Activity id
        *  @param: integer Subscription_id => Subscription id
        *  @param: integer type => Type of check: 1 for in, 2 for out
        */
        public function newCheckByPanel(Request $request){
          $adminController = new AdminController;
          $person = $adminController->getPerson();
          if($person){
            $activity = Activity::find($request->input("Activity_id"));
            if($activity){
              $subscription = Subscription::find($request->input("Subscription_id"));
              if($subscription){
                $subscriptionController = new SubscriptionController;
                if($subscriptionController->isPaid($request->input("Subscription_id"))){
                  if($subscriptionController->havePermission($request->input("Subscription_id"), $request->input("Activity_id"))){
                    if(!empty($request->input("type"))){
                      $check = new Check;
                      $check->type = $this->typeCheck[$request->input("type")];
                      $check->User_id = $person->user->id;
                      $check->Subscription_id = $request->input("Subscription_id");
                      $check->Activity_id = $request->input("Activity_id");
                      $check->checked_at = date("Y-m-d H:i:s",time()+(60*60*3));
                      $check->save();
                      return response()->json(array("ok" => 1));
                    }else{
                      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.1", "message" => "É necessário selecionar qual é o tipo de registro que deseja realizar: check-in ou check-out."));
                    }
                  }else{
                    return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.2", "message" => "A inscrição informada não tem acesso a essa atividade."));
                  }
                }else{
                  return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.3", "message" => "A inscrição informada não está confirmada."));
                }
              }else{
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.4", "message" => "A inscrição informada não existe."));
              }
            }else{
              return response()->json(array("ok" => 0, "error" => 1, "typeError" => "10.5", "message" => "A atividade informada não existe."));
            }
          }else{
            return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 401);
          }
        }


       /*
        *  @route: /api/mobile/check/new/list
        *
        *  @method: Post
        *
        *  @param: array checks => Array of checks. The params of this array:
        *     @param: integer Activity_id => Activity id
        *     @param: integer Subscription_id => Subscription id
        *     @param: integer type => Type of check: 1 for in, 2 for out
        *     @param: integer checked_at => Date in format yyyy-mm-dd hh:ii:ss
        */
        public function listCheck(Request $request){
          $person = PessoaController::verifyLoginMobile($request->input("document"), $request->input("token"));
          if($person){
            $count["all"] = 0;
            $count["ok"] = 0;
            $count["errors"] = 0;
            $httpCode = NULL;
            $error = array();
            if($request->input("checks")){
              foreach($request->input("checks") as $Check){
                $activity = Activity::find($Check["Activity_id"]);
                if($activity){
                  $subscription = Subscription::find($Check["Subscription_id"]);
                  if($subscription){
                    $subscriptionController = new SubscriptionController;
                    if($subscriptionController->isPaid($Check["Subscription_id"])){
                      if($subscriptionController->havePermission($Check["Subscription_id"], $Check["Activity_id"])){
                        if(!empty($Check["type"])){
                          $check = new Check;
                          $check->type = $this->typeCheck[$Check["type"]];
                          $check->User_id = $person->user->id;
                          $check->Subscription_id = $Check["Subscription_id"];
                          $check->Activity_id = $Check["Activity_id"];
                          $check->checked_at = $Check["checked_at"];
                          $check->save();
                          $count["ok"]++;
                        }else{
                          $newError = array(
                            "Subscription_id" => $Check["Subscription_id"],
                            "Activity_id" => $Check["Activity_id"],
                            "checked_at" => $Check["checked_at"],
                            "typeError" => "10.1",
                            "message" => "É necessário informar qual é o tipo de registro que deseja realizar: check-in ou check-out."
                          );
                          $error[] = $newError;
                          $count["errors"]++;
                        }
                      }else{
                        $newError = array(
                          "Subscription_id" => $Check["Subscription_id"],
                          "Activity_id" => $Check["Activity_id"],
                          "checked_at" => $Check["checked_at"],
                          "typeError" => "10.2",
                          "message" => "A inscrição informada não tem acesso a essa atividade."
                        );
                        $error[] = $newError;
                        $count["errors"]++;
                      }
                    }else{
                      $newError = array(
                        "Subscription_id" => $Check["Subscription_id"],
                        "Activity_id" => $Check["Activity_id"],
                        "checked_at" => $Check["checked_at"],
                        "typeError" => "10.3",
                        "message" => "A inscrição informada não está confirmada."
                      );
                      $error[] = $newError;
                      $count["errors"]++;
                    }
                  }else{
                    $newError = array(
                      "Subscription_id" => $Check["Subscription_id"],
                      "Activity_id" => $Check["Activity_id"],
                      "checked_at" => $Check["checked_at"],
                      "typeError" => "10.4",
                      "message" => "A inscrição informada não existe."
                    );
                    $error[] = $newError;
                    $count["errors"]++;
                  }
                }else{
                  $newError = array(
                    "Subscription_id" => $Check["Subscription_id"],
                    "Activity_id" => $Check["Activity_id"],
                    "checked_at" => $Check["checked_at"],
                    "typeError" => "10.5",
                    "message" => "A atividade informada não existe."
                  );
                  $error[] = $newError;
                  $count["errors"]++;
                }
                $count["all"]++;
              }
            }else{
              $httpCode = 204;
            }
            if(!$httpCode){
              if($count["errors"] > 0){
                $httpCode = 422;
              }else{
                $httpCode = 200;
              }
            }
            return response()->json(array(
              "count" => $count,
              "errors" => $error,
            ), $httpCode);
          }else{
            return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 401);
          }
        }


        public function removeCheck($id){
          $person = AdminController::getPerson();
          if($person){
            $check = Check::find($id);
            if($check){
              LogController::make("O usuário removeu o registro de presença de '".$check->subscription->person->id." - ".$check->subscription->person->name."' na atividade '".$check->activity->id." - ".$check->activity->name."' de tipo de '".$check->type."' às '".date("d/m/Y H:i:s",strtotime($check->checked_at))."'.");
              $check->delete();
            }
            return redirect()->back();
          }
          return redirect("/");
        }
}
