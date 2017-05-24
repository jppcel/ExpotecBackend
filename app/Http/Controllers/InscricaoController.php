<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PessoaController;
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
   *  @param  integer address.type_street  => Type Address of Person's Address
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
    // Faz a validação dos dados
    $validator = \Validator::make($request->all(), [
      'person.name' => 'required|string|min:5|max:60',
      'person.document' => 'required|cpf|min:14|max:14|unique:Person,document',
      'person.email' => 'required|string|min:5|max:100|unique:Person,email',
      'address.zip' => 'required|string|min:9|max:9',
      'address.type_street' => 'required|string|max:100',
      'address.street' => 'required|string|max:100',
      'address.number' => 'nullable|string|max:5',
      'address.neighborhood' => 'nullable|string|max:40',
      'address.city' => 'required|integer',
      'phone.ddd' => 'required|string|min:2|max:3',
      'phone.number' => 'required|string|min:8|max:9'
    ]);
    // Se a validação falha, retorna um JSON de erro
    if($validator->fails()){
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.0", "errors" => $validator->errors()), 422);
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
            if($request->input("university.is_from_another_college") == 0){
              $person->college = $request->input("university.college");
              $person->course = $request->input("university.course");
              $person->univelStudent = 0;
            }else{
              $person->univelStudent = 1;
            }
          }else{
            $person->univelStudent = 0;
          }
          $person->save();
          if($person->id > 0){
            $address = new Address;
            $address->Person_id = $person->id;
            $address->TypeStreet_id = $request->input("address.type_street");
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
                  Mail::send('mail.ActivationLink', ["link" => env("APP_URL")."/token/".$person->id."/".$user->remember_token], function($message) use ($person){
                    $message->to($person->email, $person->nome)->subject('Cadastro realizado na ".env("APP_NAME")." - Necessita ativação.');
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
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.1", "message" => "A cidade informada não existe."));
        }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "1.2", "message" => "O CEP não foi informado."));
      }
    }
  }


  /**
   *  @route: /api/web/inscricao/pessoa/{id}/{token}
   *
   *  @method: Get
   */
  public function getPessoa($id, $token){
    $person = Person::find($id);
    if($person){
      if($person->user->remember_token == $token){
        return response()->json(array("ok" => 1, "nome" => $person->name));
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.1", "message" => "O token informado não é válido."));
      }
    }else{
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.2", "message" => "O usuário informado não existe."));
    }
  }


  /**
   *  @route: /api/web/inscricao/activate
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
      if($person->user->remember_token == $request->input("token") && $person->user->password == NULL){
        // Faz a validação dos dados
        $validator = \Validator::make($request->all(), [
          'password' => 'required|string|min:8|max:60|confirmed'
        ]);
        // Se a validação falha, retorna um json de erro
        if($validator->fails()){
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.0", "errors" => $validator->errors()), 422);
        }else{
          $person->user->password = bcrypt($request->input("senha"));
          $person->user->remember_token = sha1($person->Cpf . date("YmdHis"));
          $person->user->save();
          return response()->json(array("ok" => 1, "token" => $person->user->remember_token));
        }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.1", "message" => "Um erro inesperado aconteceu."));
      }
    }else{
      return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.2", "message" => "O usuário informado não existe."));
    }
  }


    /**
     *  @route: /api/web/inscricao/pacote
     *
     *  @method: Post
     *
     *  @param  string cpf => [14] id of Person
     *  @param  string token => token of this session
     *  @param  integer package_id => Pacote's Id
     *  @param  integer activity_id => Atividade's id (nullable)
     */
    public function makeInscricao(Request $request){
      $person = PessoaController::verifyLogin($request->input("cpf"), $request->input("token"));
      if($person){
          foreach($person->packages->all() as $package){
            foreach($package->payment->all() as $payment){
              if($payment->paymentStatus == 3){
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.1", "message" => "Já há uma inscrição confirmada para esse usuário."));
                exit();
              }elseif($payment->paymentStatus == 2){
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.2", "message" => "Há um pagamento pendente de uma inscrição, caso a mesma seja cancelada, poderá ser feita uma nova inscrição."));
              }
            }
          }

          $subscription = new Subscription;
          $subscription->Person_id = $person->id;
          $subscription->Package_id = $request->input("package_id");
          $subscription->save();
          if($subscription->id > 0){
            if($request->input("activity_id")){
              $atividade = Activity::find($request->input("activity_id"));
              $subscriptionActivity = new Subscription_Activity;
              $subscriptionActivity->Subscription_id = $subscription->id;
              $subscriptionActivity->Activity_id = $request->input("activity_id");

              $subscriptionActivity->save();
            }
          }

          $package = Package::find($subscription->Package_id);

          $City = $person->address->city;
          $State = $City->state;

          \PagSeguro\Library::initialize();
          \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
          \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

          $payment = new \PagSeguro\Domains\Requests\Payment();
          $payment->addItems()->withParameters($package->id, env("APP_NAME").' - Pacote: '.$package->name, 1, $package->value);
          $payment->setCurrency("BRL");
          $payment->setReference($subscription->id);
          $payment->setSender()->setName($person->Nome);
          $payment->setSender()->setEmail($person->Email);
          $payment->setSender()->setDocument()->withParameters(
              'CPF',
              $person->document
          );
          $payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::NOT_SPECIFIED);
          $payment->setRedirectUrl(env("APP_REDIRECT_PAGSEGURO"));
          $payment->setNotificationUrl(env("APP_NOTIFICATION_PAGSEGURO"));
          try {
              $result = $payment->register(\PagSeguro\Configuration\Configure::getAccountCredentials(), true);
              $payment = new Payment;
              $payment->Subscription_id = $subscription->id;
              $payment->Transaction_id = $result->getCode();
              $payment->paymentStatus = 1;
              $payment->save();
              $retorno["ok"] = 1;
              $retorno["redirectURL"] = "https://pagseguro.uol.com.br/v2/checkout/payment.html?code=".$result->getCode();
              echo json_encode($retorno);
          } catch (Exception $e) {
              die($e->getMessage());
          }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."));
      }
    }

    public function test(Request $request){
      // foreach(TypeStreet::all() as $typeStreet){
      //   echo "DB::Table('TypeStreet')->insert(array('id' => ".$typeStreet->id.", 'state_id' => '".$typeStreet->name."'));<br/>";
      // }
      $f = fopen('C:\Users\Joao Paulo\git\ExpotecBackend\public\ceps.csv', 'r');
      if($f){
        $i = 1;
        $zip = ZIP::orderBy('id', 'desc')->first();
        for($j = 1; $j <= $zip->line; $j++){
          fgetcsv($f, 0, ",");
          $i++;
        }
        while (!feof($f)) {
          $linha = fgetcsv($f, 0, ",");
          if($i > $zip->line){
            if(count(ZIP::where("zipcode", $linha[0])->get()) == 0){
              echo $linha[0]."<br>";
              $UF = State::where("UF", $linha[3])->first();
              $city = City::where([
                "State_id" => $UF->id,
                 "name" => $linha[4]
                 ])->first();
              if($city == null){
                $city = new City;
                $city->name = $linha[4];
                $city->State_id = $UF->id;
                if(count($linha) == 8){
                  if($linha[7]){
                    $city->Cod_Ibge = $linha[7];
                  }
                }
                $city->save();
              }
              $typeStreet = TypeStreet::where(["name" => $linha[1]])->first();
              $zip = new ZIP;
              $zip->City_id = $city->id;
              $zip->TypeStreet_id = $typeStreet->id;
              $zip->zipcode = $linha[0];
              $zip->neighborhood = $linha[5];
              $zip->name = $linha[2];
              $zip->line = $i-1;
              $zip->save();
            }
          }
          $i++;
        }
        echo $i;
        print_r($list);
      }
    }

    public function listCities(){
      $cities = City::all();
      foreach($cities as $city){
        echo "DB::Table('TypeStreet')->insert(array('id' => ".$city->id.", 'name' => \"".mb_strtoupper($city->name, "utf-8")."\", Cod_Ibge => \"".$city->Cod_Ibge."\", State_id => ".$city->State_id."));<br>";
      }
    }
}
