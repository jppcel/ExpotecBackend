<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

// Importado o arquivo Util para uso
use App\Http\Util\Util;
use App\Subscription;
use App\Person;
use App\User;
use App\TypeStreet;
use App\Permission;

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

    public function person_new_post(Request $request){


        $messages = [
          'name.required' => 'O seu nome é necessário para efetuarmos sua inscrição.',
          'email.required' => 'O seu email é necessário para efetuarmos sua inscrição.',
          'email.unique' => 'O email informado já está vinculado a outro cadastro.',
          'document.required' => 'O seu CPF é necessário para efetuarmos sua inscrição.',
          'document.unique' => 'O CPF informado já está vinculado a outro cadastro.',

          'name.between' => 'O seu nome precisa ter pelo menos 5 até 60 caracteres.',
          'document.between' => 'O seu CPF precisa ter pelo menos 11 caracteres.'
        ];
        // Faz a validação dos dados
        $requisicao = $request->all();
        $requisicao["document"] = Util::CPFNumbers($requisicao["document"]);
        $validator = \Validator::make($requisicao, [
          'name' => 'required|string|min:5|max:60',
          'document' => 'required|cpf|min:11|max:14|unique:Person,document',
          'email' => 'required|string|min:5|max:100|unique:Person,email',
          'password' => 'required|string|min:8|max:60|confirmed'
        ], $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }else{
          $person = new Person;
          $person->name = $request->input("name");
          $person->document = $requisicao["document"];
          $person->email = $request->input("email");
          if(count($request->input("isStudent")) > 0){
            $person->college = $request->input("college");
            $person->course = $request->input("course");
          }
          $person->univelStudent = 0;
          $person->save();


          $user = new User;
          $user->is_admin = false;
          $user->is_active = false;
          $user->Person_id = $person->id;
          $user->last_update = date("Y-m-d H:i:s");
          $user->password = bcrypt($request->input("password"));
          $user->remember_token = sha1($person->document . date("YmdHis"));
          $user->save();
          return redirect(url("/person/dashboard/".$person->id));
        }
    }



    public function person_dashboard($id){
      $args["person_dashboard"] = Person::find($id);
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $adminController = new AdminController;
      $args["person"] = AdminController::getPerson();
      $args["typestreet"] = TypeStreet::all();
      $args["permission"] = Permission::all();
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      $args["is_admin"] = $adminController->hasPermission([3,4]);
      return view("painel.person.dashboard", compact("args"));
    }

    public function person_list(){
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $args["person"] = AdminController::getPerson();
      $args["persons"] = Person::all();
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      return view("painel.person.list", compact("args"));
    }

    public function label_generate(){
      $pdf = PDF::loadFile(env("APP_URL").'/label/intern_generate');
      return $pdf->stream();
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
