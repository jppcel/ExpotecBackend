<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\DB;
use App\Subscription;
use App\Participation;
use App\Check;
use App\Activity;
use App\Certificate;

class CertificateController extends Controller
{
    public function __construct(){
      $this->middleware("verifylogin");
      $_SESSION["redirectLoopPrevent"] = 0;
    }
    public function calculateHours($id = null){
      $person = AdminController::getPerson();
      if($person){
        if($id){
          $subscriptions[] = Subscription::find($id);
        }else{
          $subscriptions = Subscription::all();
        }
        foreach($subscriptions as $subscription){
          $checks = array();
          $activities = array();
          $participations = array();
          foreach($subscription->participates->all() as $participate){
            $participations[] = $participate->Activity_id;
          }
          $checks = Check::where(["Subscription_id" => $subscription->id,"registryType" => 2])->orWhere(["Subscription_id" => $subscription->id,"registryType" => 3])->orderBy("checked_at")->get();
          foreach($checks as $check){
            if(!in_array($check->Activity_id,$participations)){
              if(isset($activities[$check->Activity_id])){
                $activities[$check->Activity_id]["id"] = $check->Activity_id;
                $activities[$check->Activity_id]["time"] = 0;
              }
              if(isset($activities[$check->Activity_id]["check"])){
                $time = strtotime($check->checked_at) - strtotime($activities[$check->Activity_id]["check"]);
                $activities[$check->Activity_id]["time"] += $time;
                $activities[$check->Activity_id]["check"] = NULL;
              }else{
                $activities[$check->Activity_id]["check"] = $check->checked_at;
              }
            }
          }
          foreach($activities as $activity){
            $Activity = Activity::find($activity["id"]);
            $participation = new Participation;
            $participation->Subscription_id = $subscription->id;
            $participation->Activity_id = $activity["id"];

            $timeActivity = strtotime($Activity->endDate) - strtotime($Activity->startDate);

            if($Activity->hours){
              if(isset($Activity->minimalParticipation)){
                $minimalTime = ($timeActivity/100)*$Activity->minimalParticipation;
                if($minimalTime <= $activity["time"]){
                  $participation->hours = $Activity->hours;
                }else{
                  $participation->hours = 0;
                }
              }else{
                $participation->hours = date("H:i:s",strtotime($Activity->hours)*($activity["time"]/$timeActivity));
              }
            }else{
              if($timeActivity >= $activity["time"]){
                $participation->hours = gmdate("H:i:s",$activity["time"]);
              }else{
                $participation->hours = gmdate("H:i:s",$timeActivity);
              }
            }
            $participation->save();
          }
        }
        if($id){
          LogController::make("O usuário fez o cálculo das horas da participação do inscrito '#".$subscriptions[0]->id." - ".$subscriptions[0]->person->name."' no evento.");
          return redirect("/person/dashboard/".$subscriptions[0]->person->id);
        }
        LogController::make("O usuário fez o cálculo das horas das participações dos inscritos no evento.");
        return redirect("/");
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }

    public function growChecks($id = null){
      $person = AdminController::getPerson();
      if($person){
        $activities = Activity::all();
        if($id){
          foreach(Check::where(["Person_id" => $id])->get() as $check){
            $check->delete();
          }
          $subscription = Subscription::find($id);
        }
        foreach($activities as $activity){
          if($id){
            $checks = Check::where(["Subscription_id" => $id, "Activity_id" => $activity->id])->get();
          }else{
            $checks = $activity->checks->all();
          }
          foreach($checks as $check){
            $checksOk = Check::where([
              "Subscription_id" =>  $check->Subscription_id,
              "Activity_id" =>  $check->Activity_id,
              "registryType" => 2
            ])->get();
            if(count($checksOk) == 0){
              $Check = new Check;
              $Check->User_id = $check->User_id;
              $Check->Subscription_id = $check->Subscription_id;
              $Check->Activity_id = $check->Activity_id;
              $Check->registryType = 2;
              $Check->type = 'in';
              $Check->checked_at = $activity->startDate;
              $Check->save();

              $Check = new Check;
              $Check->User_id = $check->User_id;
              $Check->Subscription_id = $check->Subscription_id;
              $Check->Activity_id = $check->Activity_id;
              $Check->registryType = 2;
              $Check->type = 'out';
              $Check->checked_at = $activity->endDate;
              $Check->save();
            }
          }
        }
        if($id){
          LogController::make("O usuário efetuou a geminação dos registros de presença do inscrito '#".$subscription->id." - ".$subscription->person->name."' no evento.");
          return redirect("/person/dashboard/".$subscription->person->id);
        }else{
          LogController::make("O usuário efetuou a geminação dos registros de presença dos inscritos do evento.");
        }
        return redirect("/");
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }

    public function deleteParticipations($id = null){
      if($id){
        $participations = Participation::where(["Subscription_id" => $id])->get();
        $subscription = Subscription::find($id);
      }else{
        $participations = Participation::all();
      }
      foreach($participations as $participation){
        $participation->delete();
      }
      if($id){
        LogController::make("O usuário deletou as horas calculadas das presenças do inscrito '#".$subscription->id." - ".$subscription->person->name."' no evento.");
        return redirect("/person/dashboard/".$subscription->person->id);
      }else{
        LogController::make("O usuário deletou as horas calculadas das presenças dos inscritos do evento.");
      }
      return redirect("/");
    }

    public function generateCertificates($id = null){
      if($id){
        $participations = Participation::where(["Subscription_id" => $id])->get();
        $Subscription = Subscription::find($id);
      }else{
        $participations = Participation::all();
      }
      if(count($participations) > 0){
        if($id){
          $certificates = Certificate::where(["Subscription_id" => $id])->get();
          foreach($certificates as $certificate){
            $certificate->delete();
          }
          $certificates = array();
        }else{
          $certificates = Certificate::all();
        }
        if(count($certificates) == 0){
          if($id){
            $subscriptons[] = Subscription::find($id);
          }else{
            $subscriptons = Subscription::all();
          }
          foreach($subscriptons as $subscription){
            $participations = $subscription->participates->all();
            if($participations){
              // $select = DB::table("Certificate")->selectRaw("SEC_TO_TIME(SUM(TIME_TO_SEC(hours))) as hours")->where(["Subscription_id" => 34])->toSql();

              $select = DB::table("Participation")->selectRaw("SEC_TO_TIME(SUM(TIME_TO_SEC(hours))) as hours")->where(["Subscription_id" => $subscription->id])->first();
              // echo $select."<br><br><br>";
              // print_r($select);
              if($select){
                if($select->hours){
                  // echo $select->hours;
                  if($select->hours != "00:00:00"){
                    $certificate = new Certificate;
                    $certificate->Subscription_id = $subscription->id;
                    $certificate->hours = $select->hours;
                    $certificate->key = hash("crc32", env("APP_NAME")."_".date("Y")."_".$subscription->id);
                    $certificate->save();
                    // echo " - ".$certificate->hours."<br><br>";
                  }
                }
              }
            }
          }
        }
      }
      if($id){
        LogController::make("O usuário gerou o certificado do inscrito '#".$subscription->id." - ".$subscription->person->name."' no evento.");
        return redirect("/person/dashboard/".$Subscription->person->id);
      }
      LogController::make("O usuário gerou os certificados dos inscritos do evento.");
      return redirect("/");
    }

    public function deleteCertificate($id = null){
      if($id){
        $person = AdminController::getPerson();
        if($person){
          $subscription = Subscription::find($id);
          if($subscription){
            if($subscription->certificate){
              $subscription->certificate->delete();
              LogController::make("O usuário deletou o certificado do inscrito '#".$subscription->id." - ".$subscription->person->name."' no evento.");
              return redirect()->back();
            }
          }
        }
      }else{
        foreach(Certificate::all() as $certificate){
          $certificate->delete();
        }
        LogController::make("O usuário deletou todos os certificados do evento.");
      }
      return redirect("/");
    }

    public function confirmParticipation(){
      $person = AdminController::getPerson();
      if($person){
        $subscriptions = Subscription::all();
        foreach($subscriptions as $subscription){
          $checks = array();
          foreach($subscription->checks->orderBy("checked_at") as $check){
            if($activities[$check->Activity_id]){
              $activities[$check->Activity_id]["id"] = $check->Activity_id;
              $activities[$check->Activity_id]["time"] = 0;
            }
            if($activities[$check->Activity_id]["check"]){
              $time = strtotime($activities[$check->Activity_id]["check"]) - strtotime($check->checked_at);
              $activities[$check->Activity_id]["time"] += $time;
              $activities[$check->Activity_id]["check"] = NULL;
            }else{
              $activities[$check->Activity_id]["check"] = $check->checked_at;
            }
          }
          foreach($activities as $activity){
            $participation = new Participation;
            $participation->Subscription_id = $subscription->id;
            $participation->Activity_id = $activity["id"];
            $participation->hours = date("H:i:s",$activity["time"]);
            $participation->save();
          }
        }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }
}
