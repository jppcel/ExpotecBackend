<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrilhaController extends Controller
{

    /**
     *  @route: /api/web/trilha/list
     *
     *  @method: Post
     *
     *  @param  string  cpf [14] => Password
     *  @param  string  token => Password confirmation
     *
     */
    public function listAll(){
      $trilhas = Trilhas::all();
      $retorno = NULL;
      foreach($trilhas as $trilha){
        $array = array();
        $array["nome"] = $trilha->nome;
      }
    }
}
