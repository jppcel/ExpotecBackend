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
use App\Pessoa;
use App\Cidade;
use App\Estado;
use App\Pais;
use App\CEP;
use App\Pagamento;
use App\Pacote;
use App\Atividade;
use App\Pessoa_Inscricao_Pacote;

class InscricaoController extends Controller
{
  /**
   *  @route: /api/web/inscricao/new
   *
   *  @method: Post
   *  Atribbutes:
   *    Example: - attribute(type, [limits]) => description
   *    Limits:
   *      || => or;
   *      - interval.
   *
   *  @param  string  nome [5-60] => Name of Person
   *  @param  string  cpf [14] => CPF of Person
   *  @param  string  email [5-100] => Email of Person
   *  @param  string  cep [9] => ZIP Code of Person's Address
   *  @param  string  logradouro [0-100] => Address of Person's Address
   *  @param  integer numero [0-5] => number of Person's Address (nullable)
   *  @param  string  bairro [0-40] => zone of Person's Address (nullable)
   *  @param  string  cidade [7] => Cod_IBGE of the Person's City
   *  @param  string  telefone1 [11] => Phone 1 of Person
   *  @param  string  telefone2 [0 || 11] => Phone 2 of Person (nullable)
   *  @param  string  instituicao [0-100] => College of Person (nullable)
   *  @param  string  curso [0-50] => Course of Person (nullable)
   *  @param  int alunoUnivel [1] => If is AlunoUnivel of Person (nullable)
   */
  public function postNew(Request $request){
    // Faz a validação dos dados
    $validator = \Validator::make($request->all(), [
      'person.name' => 'required|string|min:5|max:60',
      'person.document' => 'required|cpf|min:14|max:14|unique:Pessoa,Cpf',
      'person.email' => 'required|string|min:5|max:100|unique:Pessoa,Email',
      'address.zip' => 'required|string|min:9|max:9',
      'address.type_street' => 'required|string|max:100',
      'address.street' => 'required|string|max:100',
      'address.number' => 'nullable|string|max:5',
      'address.neighborhood' => 'nullable|string|max:40',
      'address.city' => 'required|integer|min:1000000|max:9999999',
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
        $cidades = Cidade::find($request->input("address.city"));
        if(count($cidades) == 1){
          $pessoa = new Pessoa;
          $pessoa->Cidade_Cod_Ibge = $request->input("address.city");
          $pessoa->Nome = $request->input("person.name");
          $pessoa->Cpf = $CPF;
          $pessoa->Logradouro = $request->input("address.type_street")." ".$request->input("street");
          $pessoa->NumEndereco = $request->input("address.number");
          $pessoa->Bairro = $request->input("address.neighborhood");
          $pessoa->Cep = $CEP;
          $pessoa->Fone1 = $request->input("phone.ddd").$request->input("phone.number");
          $pessoa->Email = $request->input("person.email");
          if(count($request->input("university")) > 0){
            if($request->input("university.is_from_another_college") == 0){
              $pessoa->Instituicao = $request->input("university.college");
              $pessoa->Curso = $request->input("university.course");
              $pessoa->AlunoUnivel = 0;
            }else{
              $pessoa->AlunoUnivel = 1;
            }
          }else{
            $pessoa->AlunoUnivel = 0;
          }
          $pessoa->remember_token = sha1($request->input("cpf") . date("YmdHis"));
          $pessoa->save();
          Mail::send('mail.ActivationLink', ["link" => env("APP_URL")."/token/".$pessoa->id."/".$pessoa->remember_token], function($message) use ($pessoa){
            $message->to($pessoa->Email, $pessoa->Nome)->subject('Cadastro realizado na Expotec - Necessita ativação.');
          });
          return response()->json(array("ok" => 1));
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
    $pessoa = Pessoa::find($id);
    if($pessoa){
      if($pessoa->remember_token == $token){
        return response()->json(array("ok" => 1, "nome" => $pessoa->Nome));
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
   *  @param  string  senha [8-60] => Password
   *  @param  string  senha_confirmation [8-60] => Password confirmation
   */
  public function activateInscricao(Request $request){
    $pessoa = Pessoa::find($request->input("id"));
    if($pessoa){
      if($pessoa->remember_token == $request->input("token") && $pessoa->Senha == NULL){
        // Faz a validação dos dados
        $validator = \Validator::make($request->all(), [
          'senha' => 'required|string|min:8|max:60|confirmed'
        ]);
        // Se a validação falha, retorna um json de erro
        if($validator->fails()){
          return response()->json(array("ok" => 0, "error" => 1, "typeError" => "2.0", "errors" => $validator->errors()), 422);
        }else{
          $pessoa->Senha = bcrypt($request->input("senha"));
          $pessoa->remember_token = sha1($pessoa->Cpf . date("YmdHis"));
          $pessoa->save();
          return response()->json(array("ok" => 1, "token" => $pessoa->remember_token));
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
     *  @param  integer idPacote => Pacote's Id
     *  @param  integer idAtividade => Atividade's id (nullable)
     */
    public function makeInscricao(Request $request){
      $pessoa = PessoaController::verifyLogin($request->input("cpf"), $request->input("token"));
      if($pessoa){
          foreach($pessoa->pacotes->all() as $pacote){
            foreach($pacote->pagamento->all() as $pagamento){
              if($pagamento->statusPagamento == 3){
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.1", "message" => "Já há uma inscrição confirmada para esse usuário."));
                exit();
              }elseif($pagamento->statusPagamento == 2){
                return response()->json(array("ok" => 0, "error" => 1, "typeError" => "3.2", "message" => "Há um pagamento pendente de uma inscrição, caso a mesma seja cancelada, poderá ser feita uma nova inscrição."));
              }
            }
          }

          $pacote = new Pessoa_Inscricao_Pacote;
          $pacote->Pessoa_id = $pessoa->id;
          $pacote->Pacote_id = $request->input("idPacote");
          if($request->input("idAtividade")){
            $atividade = Atividade::find($request->input("idAtividade"));
            if($atividade->limite){
              $atividade->vagas--;
            }
            $pacote->Atividade_id = $request->input("idAtividade");
          }
          $pacote->save();
          if($pacote->save){
            if($request->input("idAtividade")){
              $atividade->save();
            }
          }

          $Pacote = Pacote::find($pacote->Pacote_id);

          $Cidade = $pessoa->cidade;
          $Estado = $Cidade->estado;

          \PagSeguro\Library::initialize();
          \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
          \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

          $payment = new \PagSeguro\Domains\Requests\Payment();
          $payment->addItems()->withParameters($Pacote->id, 'Expotec 2017 - Pacote: '.$Pacote->nome, 1, $Pacote->valor);
          $payment->setCurrency("BRL");
          $payment->setReference($pacote->id);
          $payment->setSender()->setName($pessoa->Nome);
          $payment->setSender()->setEmail($pessoa->Email);
          $payment->setSender()->setDocument()->withParameters(
              'CPF',
              $pessoa->Cpf
          );
          $payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::NOT_SPECIFIED);
          $payment->setRedirectUrl("http://www.polles.xyz");
          $payment->setNotificationUrl("http://www.polles.xyz/nofitication");
          try {
              $result = $payment->register(\PagSeguro\Configuration\Configure::getAccountCredentials(), true);
              $pagamento = new Pagamento;
              $pagamento->Pessoa_Inscricao_Pacote_id = $pacote->id;
              $pagamento->idTransacao = $result->getCode();
              $pagamento->statusPagamento = 1;
              $pagamento->save();
              $retorno["ok"] = 1;
              $retorno["redirectURL"] = "https://pagseguro.uol.com.br/v2/checkout/payment.html?code=".$result->getCode();
              // print_r($result->getCode());
              echo json_encode($retorno);
          } catch (Exception $e) {
              die($e->getMessage());
          }
      }else{
        return response()->json(array("ok" => 0, "error" => 1, "typeError" => "0.0", "message" => "Usuário deslogado."));
      }
    }

    public function test(Request $request){
      print_r($request->all());
    }
}
