<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Request\NewSubscription;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PacoteController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

// Importado o arquivo Util para uso
use App\Http\Util\Util;

// Importando os Models que serão utilizados nesse controller
use App\Person;
use App\City;
use App\State;
use App\Country;
use App\ZIP;
use App\Payment;
use App\PaymentMethod;
use App\Package;
use App\Address;
use App\Phone;
use App\User;
use App\Activity;
use App\TypeStreet;
use App\Subscription;
use App\Subscription_Activity;

class InscricaoController extends Controller
{
  /**
   *  @route: /api/web/subscription/new
   *
   *  @method: Post
   *  Atribbutes:
   *    Example: - attribute(type, [limits]) => description
   *    Limits:
   *      || => or;
   *      - interval.
   *
   *  @param  string  person.nome [5-60] => Name of Person
   *  @param  string  person.document [14] => CPF of Person
   *  @param  string  person.email [5-100] => Email of Person
   *  @param  string  address.zip [9] => ZIP Code of Person's Address
   *  @param  integer address.typeStreet  => Type Address of Person's Address
   *  @param  string  address.street [0-100] => Address of Person's Address
   *  @param  integer address.number [0-5] => number of Person's Address (nullable)
   *  @param  string  address.neighborhood [0-40] => zone of Person's Address (nullable)
   *  @param  integer address.city [7] => id of the Person's City
   *  @param  string  phone.ddd [2-3] => Phone 1 of Person
   *  @param  string  phone.number [8-9] => Phone 2 of Person
   *  @param  string  university.college [0-100] => College of Person (nullable)
   *  @param  string  university.course [0-50] => Course of Person (nullable)
   *  @param  int university.is_from_another_college [1] => If is student of other university of Person (nullable)
   */
  public function postNew(Request $request){

    $messages = [
      'person.name.required' => 'O seu nome é necessário para efetuarmos sua inscrição.',
      'person.email.required' => 'O seu e-mail é necessário para efetuarmos sua inscrição.',
      'person.document.required' => 'O seu CPF é necessário para efetuarmos sua inscrição.',
      'person.document.unique' => 'O CPF informado já está em uso.',
      'person.email.unique' => 'O e-mail informado já está em uso.',
      'address.zip.required' => 'O CEP de seu endereço é necessário para efetuarmos sua inscrição.',
      'address.typeStreet.required' => 'O tipo de endereço de seu endereço é necessário para efetuarmos sua inscrição.',
      'address.street.required' => 'O logradouro de seu endereço é necessário para efetuarmos sua inscrição.',
      'address.city.required' => 'A cidade de seu endereço é necessário para efetuarmos sua inscrição.',
      'phone.ddd.required' => 'O DDD de seu telefone é necessário para efetuarmos sua inscrição.',
      'phone.number.required' => 'O número de seu telefone é necessário para efetuarmos sua inscrição.',


      'person.name.between' => 'O seu nome precisa ter pelo menos 5 até 60 caracteres.',
      'person.document.between' => 'O seu CPF precisa ter pelo menos 11 caracteres.',
      'person.document.between' => 'O CEP de seu endereço precisa ter 8 dígitos.',
      'phone.ddd.between' => 'O DDD de seu telefone precisa ter 2 ou 3 dígitos.',
      'phone.number.between' => 'O número de seu telefone precisa ter 8 ou 9 dígitos.',


      'address.street.between' => 'O logradouro de seu endereço precisa ter até 100 caracteres.',
      'address.number.between' => 'O número de seu endereço precisa ter até 5 dígitos.',
      'address.neighborhood.between' => 'O bairro de seu endereço precisa ter até 40 dígitos.'
    ];
    // Faz a validação dos dados
    $validator = \Validator::make($request->all(), [
      'person.name' => 'required|string|min:5|max:60',
      'person.document' => 'required|cpf|min:11|max:14|unique:Person,document',
      'person.email' => 'required|string|min:5|max:100|unique:Person,email',
      'address.zip' => 'required|string|min:8|max:9',
      'address.typeStreet' => 'required|integer',
      'address.street' => 'required|string|max:100',
      'address.number' => 'nullable|string|max:5',
      'address.neighborhood' => 'nullable|string|max:40',
      'address.city' => 'required|integer',
      'phone.ddd' => 'required|string|min:2|max:3',
      'phone.number' => 'required|string|min:8|max:9'
    ], $messages);
    // Se a validação falha, retorna um JSON de erro
    if($validator->fails()){
      $validateErros = $validator->errors();
      LogController::make("Ocorreu um erro de validação ao efetuar o cadastro pelo método InscricaoController@postNew. Infos: ".implode(",\n",$validateErros),2);
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.0", "errors" => $validateErros), 422);
    }else{
      $CPF = Util::CPFNumbers($request->input("person.document"));
      $CEP = Util::CEPNumbers($request->input("address.zip"));
      if($CEP){
        // Agora confere se a cidade informada existe
        $cities = City::find($request->input("address.city"));
        if(count($cities) == 1){
          $person = new Person;
          $person->name = $request->input("person.name");
          $person->document = $CPF;
          $person->email = $request->input("person.email");
          if(count($request->input("university")) > 0){
            $person->college = $request->input("university.college");
            $person->course = $request->input("university.course");
          }
          $person->univelStudent = 0;
          $person->save();
          if($person->id > 0){
            $address = new Address;
            $address->Person_id = $person->id;
            $address->TypeStreet_id = $request->input("address.typeStreet");
            $address->street = $request->input("address.street");
            $address->number = $request->input("address.number");
            $address->neighborhood = $request->input("address.neighborhood");
            $address->complement = $request->input("address.complement");
            $address->zip = $CEP;
            $address->City_id = $request->input("address.city");
            $address->save();
            if($address->id > 0){
              $phone = new Phone;
              $phone->Person_id = $person->id;
              $phone->ddd = $request->input("phone.ddd");
              $phone->number = $request->input("phone.number");
              $phone->save();
              if($phone->id > 0){
                $user = new User;
                $user->is_admin = false;
                $user->is_active = false;
                $user->Person_id = $person->id;
                $user->last_update = date("Y-m-d H:i:s");
                $user->remember_token = sha1($request->input("person.document") . date("YmdHis"));
                $user->save();
                if($user->id > 0){
                  LogController::make("Foi efetuado um cadastro pelo método InscricaoController@postNew. Infos: Nome: ".$request->input("name").", CPF: ".$request->input("document").", Email: ".$request->input("email").".",2);
                  Mail::send('mail.ActivationLink', ["link" => env("APP_URL_FRONT")."/token/".$person->id."/".$user->remember_token], function($message) use ($person){
                    $message->to($person->email, $person->name)->subject('Cadastro realizado na '.env("APP_NAME").' - Necessita ativação.');
                  });
                  return response()->json(array("ok" => 1));
                }else{

                }
              }else{

              }
            }else{

            }
          }
        }else{
          LogController::make("Ocorreu um erro de Cidade ao efetuar o cadastro pelo método InscricaoController@postNew. Infos: O código de cidade informado não existe. Nome: ".$request->input("name").", CPF: ".$request->input("document").", Email: ".$request->input("email").".",2);
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.1", "message" => "A cidade informada não existe."), 422);
        }
      }else{
        LogController::make("Ocorreu um erro de CEP ao efetuar o cadastro pelo método InscricaoController@postNew. Infos: O CEP não foi informado. Nome: ".$request->input("name").", CPF: ".$request->input("document").", Email: ".$request->input("email").".",2);
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.2", "message" => "O CEP não foi informado."), 422);
      }
    }
  }


  /**
   *  @route: /api/web/subscription/person/{id}/{token}
   *
   *  @method: Get
   */
  public function getPessoa($id, $token){
    $person = Person::find($id);
    if($person){
      if($person->user->remember_token == $token){
        return response()->json(array("ok" => 1, "nome" => $person->name));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.1", "message" => "O token informado não é válido."), 422);
      }
    }else{
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.2", "message" => "O usuário informado não existe."), 404);
    }
  }


  /**
   *  @route: /api/web/subscription/activate
   *
   *  @method: Post
   *
   *  @param  integer id => id of Person
   *  @param  string  token => token of this session
   *  @param  string  password [8-60] => Password
   *  @param  string  password_confirmation [8-60] => Password confirmation
   */
  public function activateInscricao(Request $request){
    $person = Person::find($request->input("id"));
    if($person){
      if($person->user->remember_token == $request->input("token") && $person->user->password == NULL && $person->user->is_active == 0){
        // Faz a validação dos dados
        $validator = \Validator::make($request->all(), [
          'password' => 'required|string|min:8|max:60|confirmed'
        ]);
        // Se a validação falha, retorna um json de erro
        if($validator->fails()){
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.0", "errors" => $validator->errors()), 422);
        }else{
          $person->user->password = bcrypt($request->input("password"));
          $person->user->remember_token = sha1($person->document . date("YmdHis"));
          $person->user->is_active = 1;
          $person->user->save();
          LogController::make("Foi setada a senha de um usuário pelo método InscricaoController@activateInscricao. Infos: Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
          return response()->json(array("ok" => 1, "token" => $person->user->remember_token));
        }
      }else{
        LogController::make("Foi efetuada uma tentativa de setar a senha de um usuário pelo método InscricaoController@activateInscricao. Infos: Um erro inesperado aconteceu. É possível que já tenha setado a senha. Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.1", "message" => "Um erro inesperado aconteceu. É possível que você já tenha setado a senha."), 422);
      }
    }else{
      LogController::make("Foi efetuada uma tentativa de setar a senha de um usuário pelo método InscricaoController@activateInscricao. Infos: O código de usuário informado não existe. ID: ".$request->input("id"),2);
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.2", "message" => "O usuário informado não existe."), 404);
    }
  }


    /**
     *  @route: /api/web/subscription/package
     *
     *  @method: Post
     *
     *  @param  string document => [14] id of Person
     *  @param  string token => token of this session
     *  @param  integer package_id => Pacote's Id
     */
    public function makeInscricao(Request $request){
      $person = PessoaController::verifyLogin($request->input("document"), $request->input("token"));
      if($person){
          foreach($person->packages->all() as $package){
            foreach($package->payment->all() as $payment){
              if($payment->paymentStatus == 3){
                LogController::make("Foi efetuada uma tentativa de selecionar um pacote e geração de código do pagseguro pelo método InscricaoController@makeInscricao. Infos: Já há uma inscrição confirmada para esse usuário. Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.1", "message" => "Já há uma inscrição confirmada para esse usuário."), 422);
                exit();
              }elseif($payment->paymentStatus == 2){
                LogController::make("Foi efetuada uma tentativa de selecionar um pacote e geração de código do pagseguro pelo método InscricaoController@makeInscricao. Infos: Há uma inscrição com pagamento pendente para esse usuário. Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.2", "message" => "Há um pagamento pendente de uma inscrição, caso a mesma seja cancelada, poderá ser feita uma nova inscrição."), 422);
              }
            }
          }

          $package = Package::find($request->input("package_id"));
          if($package){
            if($package->coupon != NULL){
              if($package->coupon != $request->input("coupon")){
                LogController::make("Foi efetuada uma tentativa de selecionar um pacote e geração de código do pagseguro pelo método InscricaoController@makeInscricao. Infos: O pacote selecionado é privado e é necessário de código de cupom para a aquisição dele. Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.3", "message" => "O pacote selecionado é privado e é necessário de código de cupom para a aquisição dele."), 422);
              }
            }
            if(!PacoteController::verifyLimit($package->id)){
              LogController::make("Foi efetuada uma tentativa de selecionar um pacote e geração de código do pagseguro pelo método InscricaoController@makeInscricao. Infos: O pacote selecionado não está aceitando mais inscrições. Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
              return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.5", "message" => "O pacote selecionado não está aceitando mais inscrições."), 422);
            }
          }else{
            LogController::make("Foi efetuada uma tentativa de selecionar um pacote e geração de código do pagseguro pelo método InscricaoController@makeInscricao. Infos: O pacote informado não existe. Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
            return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.4", "message" => "O pacote informado não existe."), 422);
          }

          $subscription = new Subscription;
          $subscription->Person_id = $person->id;
          $subscription->Package_id = $request->input("package_id");
          $subscription->save();

          $City = $person->address->city;
          $State = $City->state;

          $reference = env("PAGSEGURO_REFERENCE")."_".md5($subscription->id.$person->id.rand(0,1000));

          \PagSeguro\Library::initialize();
          \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
          \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

          $payment = new \PagSeguro\Domains\Requests\Payment();
          $payment->setReference($reference);
          $payment->addItems()->withParameters($package->id, env("APP_NAME").' - Pacote: '.$package->name, 1, $package->value);
          $payment->setCurrency("BRL");
          $payment->setSender()->setName($person->Nome);
          $payment->setSender()->setEmail($person->Email);
          $payment->setSender()->setDocument()->withParameters(
              'CPF',
              $person->document
          );
          $payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::NOT_SPECIFIED);

          foreach(PaymentMethod::all() as $paymentMethod){
            if(strtotime($paymentMethod->endDate) > time()){
              $payment->acceptPaymentMethod()->group($paymentMethod->tag);
            }else{
              $payment->excludePaymentMethod()->group($paymentMethod->tag);
            }
          }

          $payment->setRedirectUrl(env("APP_REDIRECT_PAGSEGURO"));
          $payment->setNotificationUrl(env("APP_NOTIFICATION_PAGSEGURO"));
          try {
              if($package->value > 0.00){
                $result = $payment->register(\PagSeguro\Configuration\Configure::getAccountCredentials(), true);
              }
              // $result = $payment->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
              // print_r($result);
              $payment = new Payment;
              $payment->Subscription_id = $subscription->id;
              // $payment->code = $result;
              $retorno["ok"] = 1;
              if($package->value == 0.00){
                $payment->paymentStatus = 3;
                $payment->isFree = true;
                $retorno["paid"] = true;
              }else{
                $payment->code = $result->getCode();
                $payment->Transaction_id = $reference;
                $payment->paymentStatus = 1;
                $retorno["paid"] = false;
                $retorno["code"] = $result->getCode();
              }
              $payment->save();
              // $retorno["code"] = $result;
              $retorno["payment_id"] = $payment->id;
              if($package->value == 0.00){
                LogController::make("Foi efetuada a seleção de um pacote com inscrição gratuíta pelo método InscricaoController@makeInscricao. Infos: Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
                Mail::send('mail.PaymentNewFree',
    						[
    							"subscription_id" => $payment->subscription->id,
    							"person_name" => $payment->subscription->person->name,
    							"package_name" => $payment->subscription->package->name,
    							"package_price" => $payment->subscription->package->value
    						], function($message) use ($payment){
    	            $message->to($payment->subscription->person->email, $payment->subscription->person->name)->subject(env("APP_NAME").' - Inscrição Confirmada - #'.$payment->subscription->id);
    	          });
              }else{
                LogController::make("Foi efetuada a seleção de um pacote e geração de código do pagseguro pelo método InscricaoController@makeInscricao. Infos: O código foi gerado e enviado email com confirmação do novo pedido. Nome: ".$person->name.", CPF: ".$person->document.", Email: ".$person->email.".",2);
                Mail::send('mail.PaymentNew',
    						[
    							"subscription_id" => $payment->subscription->id,
    							"person_name" => $payment->subscription->person->name,
    							"package_name" => $payment->subscription->package->name,
    							"package_price" => $payment->subscription->package->value
    						], function($message) use ($payment){
    	            $message->to($payment->subscription->person->email, $payment->subscription->person->name)->subject(env("APP_NAME").' - Novo Pedido - #'.$payment->subscription->id);
    	          });
              }

              return response()->json($retorno);
          } catch (Exception $e) {
              die($e->getMessage());
          }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."), 422);
      }
    }

    public function listSubscriptionsConfirmed(){
      $array = array();
      $subscriptions = Subscription::all();
      foreach($subscriptions as $subscription){
        foreach($subscription->payment->all() as $payment){
          if($payment->paymentStatus == 3){
            $array[] = $subscription;
          }
        }
      }
      return $array;
    }

    public function subscriptionsConfirmed(){
      return count($this->listSubscriptionsConfirmed());
    }

    public function subscriptionsRate(){
      $count = 0;
      $subscriptions = Subscription::all();
      $subscriptionsConfirmed = $this->subscriptionsConfirmed();
      return number_format($subscriptionsConfirmed/count($subscriptions)*100, 2);
    }

    public function subscriptionsListCount(){
      $array = array();
      $subscriptions = $this->listSubscriptionsConfirmed();
      foreach($subscriptions as $subscription){
        if(isset($array[$subscription->package->id])){
          $array[$subscription->package->id]['value']++;
        }else{
          $array[$subscription->package->id]['label'] = $subscription->package->name;
          $array[$subscription->package->id]['value'] = 1;
        }
      }
      return $array;
    }

    public function subscriptionsTotalPrice(){
      $count = 0.00;
      $subscriptions = $this->listSubscriptionsConfirmed();
      foreach($subscriptions as $subscription){
        $count += $subscription->package->value;
      }
      return $count;
    }



    public function label_intern_generate(){
      $inscricaoController = new InscricaoController;
      $subscriptions = $inscricaoController->listSubscriptionsConfirmed();
      return view("painel.providers.label",compact("subscriptions"));
    }



    public function qrcode($qrcode){
      $view = view("painel.providers.qrcode")->with("qrcode", $qrcode);
      return response($view)->header('Content-Type', 'image/png');
    }
}
