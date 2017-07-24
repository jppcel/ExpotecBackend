<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AdminController;
use App\Subscription;
use App\Person;

class ControlPanelController extends Controller
{

    public function __construct(){
      $this->middleware("verifylogin");
    }
    /*
    * @route /
    */
    public function index(){
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $args["subscription_count"] = $inscricaoController->subscriptionsConfirmed();
      $args["subscription_rate"] = $inscricaoController->subscriptionsRate();
      $args["subscription_list"] = $inscricaoController->subscriptionsListCount();
      $args["subscription_priceTotal"] = $inscricaoController->subscriptionsTotalPrice();
      $args["person_count"] = $personController->registerCount();
      $args["person"] = AdminController::getPerson();
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      return view("painel.index", compact("args"));
    }


    public function person_new(){
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $args["person"] = AdminController::getPerson();
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      return view("painel.person.new", compact("args"));
    }

    public function person_list(){
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $args["person"] = AdminController::getPerson();
      $args["persons"] = Person::all();
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      return view("painel.person.list", compact("args"));
    }



    public function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}
