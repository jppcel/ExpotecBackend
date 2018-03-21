<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PessoaController;
use App\Track;

class TrilhaController extends Controller
{

    /**
     *  @route: /api/web/trilha/list
     *
     *  @method: Post
     *
     *  @param  string  cpf [14] => CPF of Person
     *  @param  string  token => Token of this session
     *
     */
    public function listAll(Request $request){
      if(PessoaController::verifyLogin($request->input("cpf"), $request->input("token"))){
        $tracks = Track::all();
        $retorno = NULL;
        foreach($tracks as $track){
          $array = array();
          $array["name"] = $track->nome;
          $array["startDate"] = $track->diaInicio;
          $array["endDate"] = $track->diaFim;
          $array["acceptSubscription"] = $this->verifyLimit($track->id);
          $array["slots"] = $track->vagas;
          $activities = array();
          foreach($track->activities->all() as $activity){
            $activity_add = array();
            $activity_add["id"] = $activity->id;
            $activity_add["name"] = $activity->name;
            $activity_add["startDate"] = $activity->startDate;
            $activity_add["endDate"] = $activity->endDate;
            $speaker = $activity->speaker;
            if($speaker){
              $speaker_add = array();
              $speaker_add["name"] = $speaker->name;
              $speaker_add["photo"] = $speaker->photo;
              $speaker_add["website"] = $speaker->website;
              $speaker_add["description"] = $speaker->description;
              $activity_add["speaker"] = $speaker_add;
            }
            $activities[] = $activity_add;
          }
          $array["atividades"] = $activities;
          $retorno[] = $array;
        }
        return response()->json(array("ok" => 1, "return" => $retorno));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }

    public static function verifyLimit($id){
      $track = Track::find($id);
      if($track){
        $totalSubscriptions = 0;
        foreach($track->track_package->all() as $track_package){
          $totalSubscriptions += count($track_package->package->subscriptions->all());
        }
        if($track->slots){
          $limite = $track->slots - $totalSubscriptions;
          if($limite > 0 || $limite == NULL){
            return true;
          }else{
            return false;
          }
        }else{
          return true;
        }
      }else{
        return 0;
      }
    }
}
