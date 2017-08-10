<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\DB;

// Importado o arquivo Util para uso
use App\Http\Util\Util;
use App\Subscription;
use App\Person;
use App\Package;
use App\Activity;
use App\User;
use App\TypeStreet;
use App\Permission;
use App\UserPermission;
use App\Phone;
use App\Check;

class ControlPanelController extends Controller
{

    public function __construct(){
      $this->middleware("verifylogin");
      $_SESSION["redirectLoopPrevent"] = 0;
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
      $args["adminController"] = new AdminController;
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      return view("painel.index", compact("args"));
    }


    public function person_new(){
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $args["person"] = AdminController::getPerson();
      $args["adminController"] = new AdminController;
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
          LogController::make("O usuário adicionou uma pessoa: ".$person->id." - '".$person->name."'.");


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
      $args["checks"] = Check::where("Subscription_id","=",$id)->get();
      $args["adminController"] = new AdminController;
      $args["packages"] = Package::all();
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      $args["is_admin"] = $adminController->hasPermission([3,4]);
      $args["is_super_admin"] = $adminController->hasPermission([4]);
      return view("painel.person.dashboard", compact("args"));
    }

    public function person_phone_save(Request $request){
      $adminController = new AdminController;
      if($adminController->hasPermission([1,4])){
          $person = Person::find($request->input("Person_id"));
          if($person){
            $phone = Phone::where([["Person_id",  $person->id]])->first();
            if(!$phone){
              $phone = new Phone;
              LogController::make("O usuário alterou o telefone do cadastro da pessoa ".$person->id." - '".$person->name."' de '(".$phone->ddd.") ".$phone->number."' para '(".Util::PhoneNumbers($request->input("phone"), false).") ".Util::PhoneNumbers($request->input("phone"), true)."'.");
            }else{
              LogController::make("O usuário setou o telefone do cadastro da pessoa ".$person->id." - '".$person->name."' como '(".Util::PhoneNumbers($request->input("phone"), false).") ".Util::PhoneNumbers($request->input("phone"), true)."'.");
            }
            $phone->ddd = Util::PhoneNumbers($request->input("phone"), false);
            $phone->number = Util::PhoneNumbers($request->input("phone"), true);
            $phone->save();
            return redirect()->back();
          }
      }
      return redirect()->back();
    }

    public function person_password_save(Request $request){
      $adminController = new AdminController;
      if($adminController->hasPermission([1,4])){
        $person = Person::find($request->input("Person_id"));
        if($person){
          // Faz a validação dos dados
          $validator = \Validator::make($request->all(), [
            'password' => 'required|string|min:8|max:60|confirmed'
          ]);
          // Se a validação falha, retorna um json de erro
          if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
          }else{
            LogController::make("O usuário alterou a senha do usuário da pessoa ".$person->id." - '".$person->name."'.");
            $person->user->password = bcrypt($request->input("password"));
            $person->user->remember_token = sha1($person->document . date("YmdHis"));
            $person->user->save();
            return redirect()->back();
          }
        }
      }
      return redirect()->back();
    }

    public function person_register_save(Request $request){
      $adminController = new AdminController;
      if($adminController->hasPermission([1,4])){
        $person = Person::find($request->input("Person_id"));
        if($person){
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
          $rules['name'] = 'required|string|min:5|max:60';
          $requisicao["document"] = Util::CPFNumbers($requisicao["document"]);
          if($requisicao["document"] != $person->document){
            $rules['document'] = 'required|cpf|min:11|max:14|unique:Person,document';
          }
          if($requisicao["email"] != $person->email){
            $rules['email'] = 'required|string|min:5|max:100|unique:Person,email';
          }
          $validator = \Validator::make($requisicao, $rules, $messages);
          if($validator->fails()){
              return redirect()->back()->withErrors($validator->errors());
          }else{
            LogController::make(
              "O usuário alterou o cadastro do usuário da pessoa ".$person->id." - '".$person->name."'. Dados Antigos: ".
              "Nome: ".$person->name."\n".
              "CPF: ".$person->document."\n".
              "E-mail: ".$person->email."\n".
              "IES: ".$person->college."\n".
              "Curso: ".$person->course."."
            );
            $person->name = $request->input("name");
            $person->document = $requisicao["document"];
            $person->email = $request->input("email");
            if($request->has("isStudent")){
              $person->college = $request->input("college");
              $person->course = $request->input("course");
            }else{
              $person->college = "";
              $person->course = "";
            }
            $person->univelStudent = 0;
            $person->save();
            return redirect()->back();
          }
        }
      }
      return redirect()->back();
    }

    public function person_address_save(Request $request){
      $adminController = new AdminController;
      if($adminController->hasPermission([1,4])){
        $person = Person::find($request->input("Person_id"));
        if($person){
          $messages = [
            'zip.required' => 'O CEP de seu endereço é necessário para efetuarmos sua inscrição.',
            'TypeStreet_id.required' => 'O tipo de endereço de seu endereço é necessário para efetuarmos sua inscrição.',
            'street.required' => 'O logradouro de seu endereço é necessário para efetuarmos sua inscrição.',
            'city.required' => 'A cidade de seu endereço é necessário para efetuarmos sua inscrição.',

            'street.between' => 'O logradouro de seu endereço precisa ter até 100 caracteres.',
            'number.between' => 'O número de seu endereço precisa ter até 5 dígitos.',
            'neighborhood.between' => 'O bairro de seu endereço precisa ter até 40 dígitos.'
          ];
          // Faz a validação dos dados
          $requisicao = $request->all();
          $rules = [
            'zip' => 'required|string|min:8|max:9',
            'TypeStreet_id' => 'required|integer',
            'street' => 'required|string|max:100',
            'number' => 'nullable|string|max:5',
            'neighborhood' => 'nullable|string|max:40',
            'City_id' => 'required|integer'
          ];

          $validator = \Validator::make($requisicao, $rules, $messages);
          if($validator->fails()){
              return redirect()->back()->withErrors($validator->errors());
          }else{
            if($person->address){
              LogController::make(
                "O usuário alterou o endereço da pessoa ".$person->id." - '".$person->name."'. Dados Antigos: ".
                "Logradouro: ".$person->address->typestreet->name." ".$person->address->street.", ".$person->address->number."\n".
                "Complemento: ".$person->address->complement."\n".
                "Bairro: ".$person->address->neighborhood."\n".
                "Cidade: ".$person->address->city->name."/".$person->address->city->state->name."\n".
                "CEP: ".$person->address->zip."."
              );
              $person->address->TypeStreet_id = $request->input("TypeStreet_id");
              $person->address->street = $request->input("street");
              $person->address->number = $request->input("number");
              $person->address->complement = $request->input("complement");
              $person->address->neighborhood = $request->input("neighborhood");
              $person->address->zip = Util::CEPNumbers($request->input("zip"));
              $person->address->City_id = $request->input("City_id");
              $person->address->save();
            }else{
              LogController::make(
                "O usuário setou o endereço da pessoa ".$person->id." - '".$person->name."'."
              );
              $address = new Address;
              $address->Person_id = $person->id;
              $address->TypeStreet_id = $request->input("TypeStreet_id");
              $address->street = $request->input("street");
              $address->number = $request->input("number");
              $address->complement = $request->input("complement");
              $address->neighborhood = $request->input("neighborhood");
              $address->zip = Util::CEPNumbers($request->input("zip"));
              $address->City_id = $request->input("City_id");
              $address->save();
            }
            return redirect()->back();
          }
        }
      }
      return redirect()->back();
    }

    public function person_admin_save(Request $request){
      $adminController = new AdminController;
      if($adminController->hasPermission([1,4])){
        $person = Person::find($request->input("Person_id"));
        if($person){
          if($request->has("is_admin")){
            $log = "O usuário setou que o usuário da pessoa ".$person->id." - '".$person->name."' tem acesso admin. Permissões:";
            $person->user->is_admin = true;
            $person->user->save();
            foreach(UserPermission::where([["User_id","=",$person->user->id]])->get() as $permission){
              $permission->delete();
            }
            if($request->input("permissions")){
              foreach($request->input("permissions") as $permission){
                $Permission = new UserPermission;
                $Permission->User_id = $person->user->id;
                $Permission->Permission_id = $permission;
                $Permission->save();
                $log .= $Permission->permission->name.", ";
              }
            }
            LogController::make($log);
            return redirect()->back();
          }else{
            $log = "O usuário setou que o usuário da pessoa ".$person->id." - '".$person->name."' não tem acesso admin.";
            $person->user->is_admin = false;
            $person->user->save();
            foreach(UserPermission::where([["User_id","=",$person->user->id]])->get() as $permission){
              $permission->delete();
            }
            LogController::make($log);
          }
        }
      }
      return redirect()->back();
    }

    public function person_activate_save($Person_id){
      $adminController = new AdminController;
      if($adminController->hasPermission([1,4]) && $adminController->hasPermission([3,4])){
        $person = Person::find($Person_id);
        if($person){
          if(!$person->user->is_active){
            LogController::make("O usuário setou o usuário da pessoa ".$person->id." - '".$person->name."' como ativo.");
            $person->user->is_active = true;
            $person->user->save();
            return redirect()->back();
          }
        }
      }
      return redirect()->back();
    }

    public function person_sendConfirmation_save($Person_id){
      $adminController = new AdminController;
      if($adminController->hasPermission([1,4])){
        $person = Person::find($Person_id);
        if($person){
          if(!$person->user->is_active){
            LogController::make("O usuário enviou um novo email para confirmação da inscrição do usuário da pessoa ".$person->id." - '".$person->name."'.");
            Mail::send('mail.ActivationLink', ["link" => env("APP_URL_FRONT")."/token/".$person->id."/".$person->user->remember_token], function($message) use ($person){
              $message->to($person->email, $person->name)->subject('Reenvio: Cadastro realizado na '.env("APP_NAME").' - Necessita ativação.');
            });
            return redirect()->back();
          }
        }
      }
      return redirect()->back();
    }

    public function person_disable_save($Person_id){
      $adminController = new AdminController;
      if($adminController->hasPermission([1,4]) && $adminController->hasPermission([3,4])){
        $person = Person::find($Person_id);
        if($person){
          if($person->user->is_active){
            LogController::make("O usuário setou o usuário da pessoa ".$person->id." - '".$person->name."' como desativado.");
            $person->user->is_active = false;
            $person->user->save();
            return redirect()->back();
          }
        }
      }
      return redirect()->back();
    }




    public function person_list(){
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $args["person"] = AdminController::getPerson();
      $args["persons"] = Person::all();
      $args["adminController"] = new AdminController;
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      return view("painel.person.list", compact("args"));
    }

    public function subscription_list(){
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $args["person"] = AdminController::getPerson();
      $args["subscriptions"] = Subscription::all();
      $args["adminController"] = new AdminController;
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      return view("painel.person.subscriptions", compact("args"));
    }

    public function label_generate(){
      $pdf = PDF::loadFile(env("APP_URL").'/label/intern_generate');
      return $pdf->stream();
    }



    public function label_subscription_generate(Request $request){
      $subscriptionController = new SubscriptionController;
      $subscription = Subscription::find($request->input("Subscription_id"));
      if($subscription){
        if($subscriptionController->isPaid($subscription->id)){
          $subscriptions = array();
          for($i=0;$i<($request->input("position")-1);$i++){
            $subscriptions[] = false;
          }
          $Subscription["id"] = $subscription->id;
          $Subscription["name"] = $subscription->person->name;
          $Subscription["college"] = $subscription->person->college;
          $Subscription["package_name"] = $subscription->package->name;
          $Subscription["paymentStatus"] = $subscription->onepayment->paymentStatus;
          $subscriptions[] = $Subscription;
          return view("painel.providers.labelone",compact("subscriptions"));
        }
      }
      return view("painel.providers.errorLabel");
    }


    public function label_intern_generate(){
      $subscriptions = DB::table("Subscription")
      ->join('Person', 'Person.id', '=', 'Subscription.Person_id')
      ->join('Package', 'Package.id', '=', 'Subscription.Package_id')
      ->join('Payment', 'Payment.Subscription_id', '=', 'Subscription.id')
      ->select('Subscription.id','Person.name','Person.college','Package.name as package_name','Payment.paymentStatus')
      ->where('Payment.paymentStatus', '=', '3')
      ->orderBy("Person.name")
      ->get();
      return view("painel.providers.label",compact("subscriptions"));
    }


    public function assign_intern_generate(){
      $subscriptions = DB::table("Subscription")->join('Person', 'Person.id', '=', 'Subscription.Person_id')->join('Package', 'Package.id', '=', 'Subscription.Package_id')->join('Payment', 'Payment.Subscription_id', '=', 'Subscription.id')->select('Subscription.id','Person.name','Package.name as package_name','Payment.paymentStatus')->where('Payment.paymentStatus', '=', '3')->orderBy("Person.name")->get();
      return view("painel.providers.assign",compact("subscriptions"));
    }


    public function label_intern_generate_pending(){
      $subscriptions = DB::table("Subscription")
      ->join('Person', 'Person.id', '=', 'Subscription.Person_id')
      ->join('Package', 'Package.id', '=', 'Subscription.Package_id')
      ->join('Payment', 'Payment.Subscription_id', '=', 'Subscription.id')
      ->select('Subscription.id','Person.name','Person.college','Package.name as package_name','Payment.paymentStatus')
      ->where('Payment.paymentStatus', '=', '2')
      ->orderBy("Person.name")
      ->get();
      return view("painel.providers.label",compact("subscriptions"));
    }


    public function assign_intern_generate_pending(){
      $subscriptions = DB::table("Subscription")->join('Person', 'Person.id', '=', 'Subscription.Person_id')->join('Package', 'Package.id', '=', 'Subscription.Package_id')->join('Payment', 'Payment.Subscription_id', '=', 'Subscription.id')->select('Subscription.id','Person.name','Package.name as package_name','Payment.paymentStatus')->where('Payment.paymentStatus', '=', '2')->orderBy("Person.name")->get();
      return view("painel.providers.assign",compact("subscriptions"));
    }





    public function check_new(){
      $inscricaoController = new InscricaoController;
      $personController = new PessoaController;
      $args["person"] = AdminController::getPerson();
      $args["activities"] = Activity::all();
      $args["adminController"] = new AdminController;
      $args["person_gravatar"] = $this->get_gravatar($args["person"]->email, 160);
      return view("painel.check.new", compact("args"));
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
