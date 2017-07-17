<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

class PaymentController extends Controller
{



		/**
		 *  @route: /api/web/payment/searchPayments
		 *
		 *  @method: Get
		 *
		 */

	public function searchPendingPayments(){
		 $payments = Payment::where([
			 ["paymentStatus", "=", 1],
			 ["updated_at", "<", date("Y-m-d")." 00:00:00"]
		 ])->orWhere([
			 ["paymentStatus", "=", 2],
			 ["updated_at", "<", date("Y-m-d")." 00:00:00"]
		 ])->get();

		 foreach($payments as $payment){
		 		$response = $this->searchByReference($payment)[0];
				if($response){
			 		$payment->paymentStatus = $this->getStatus($response->getStatus());
				}
				$payment->save();
		 }
	}

	/**
		* 1	Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
		* 2	Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
		* 3	Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
		* 4	Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
		* 5	Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
		* 6	Devolvida: o valor da transação foi devolvido para o comprador.
		* 7	Cancelada: a transação foi cancelada sem ter sido finalizada.
	**/
	private function getStatus($status){
		switch ($status) {
		 	case 1:
		 	case 2:
			case 5:
		 		return 2;
		 	case 3:
		 	case 4:
		 		return 3;
			case 6:
		 	case 7:
		 	 	return 0;
		 	default:
		 		return 1;
		 }
	}

	private function searchByReference(Payment $payment){
		$options = [
	    'initial_date' => date('c',strtotime($payment->created_at))
		];

		try {
	    $response = \PagSeguro\Services\Transactions\Search\Reference::search(
        \PagSeguro\Configuration\Configure::getAccountCredentials(),
        $payment->Transaction_id,
        $options
	    );

    	return $response->getTransactions();

		} catch (Exception $e) {
	    die($e->getMessage());
		}
	}



	/**
	 *  @route: /api/web/payment/getReturn
	 *
	 *  @method: Post
	 *
	 *  @param  integer document [11 || 14] => CPF of Person
	 *  @param  string  token => token of this session
	 *  @param  integer  payment_id => Payment id
	 */
  public function getReturnPayment(Request $request){
    $payment = Payment::find($request->input("payment_id"));
    if($payment){
			$transactions = self::searchByReference($payment);
      if(count($transactions) > 0){
				foreach($transactions as $transaction){
					$payment->paymentStatus = $this->getStatus($transaction->getStatus());
					$payment->save();
				}
				$retorno = array();


				$subscription = $payment->Subscription;
				$package = $subscription->package;
				$person = $subscription->person;
				$phones = $person->phones->all();

				$address = $person->address;
				$city = $address->city;
				$state = $city->state;
				$country = $state->country;




				$retorno["payment"] = $payment;
				foreach($package->tracks_package as $track_package){
					$retorno["tracks"][] = $track_package->track;
				}
				return response()->json($retorno);
			}else{
				return response()->json(array("ok" => 0, "error" => 1, "typeError" => "7.1", "message" => "A finalização da seleção da forma de pagamento ainda não foi efetuada no pagseguro."), 422);
			}
    }else{
			return response()->json(array("ok" => 0, "error" => 1, "typeError" => "7.2", "message" => "Não existe um pagamento com o id informado."), 404);
		}
  }


}
