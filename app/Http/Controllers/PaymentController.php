<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AdminController;
use App\Payment;
use App\Subscription;
use App\PaymentUpdateLog;

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
			 ["updated_at", "<", date("Y-m-d H:i:s", (time()-(60*60*2)))]
		 ])->orWhere([
			 ["paymentStatus", "=", 2],
			 ["updated_at", "<", date("Y-m-d H:i:s", (time()-(60*60*2)))]
		 ])->get();
		 $i = 1;
		 foreach($payments as $payment){
		 		$response = $this->searchByReference($payment)[0];
				echo $i++.": ".$payment->id." - strtotime(".$payment->created_at.") < ".(time()-(60*60*24))."\n";
				if($response){
					if(strtotime($payment->created_at) < time()-(60*60*24)){
			 			$payment->paymentStatus = $this->getStatus($response->getStatus(), true);
					}else{
			 			$payment->paymentStatus = $this->getStatus($response->getStatus(), false);
					}
					if($payment->paymentStatus ==  3){
	          Mail::send('mail.PaymentConfirmed',
						[
							"subscription_id" => $payment->subscription->id,
							"person_name" => $payment->subscription->person->name,
							"package_name" => $payment->subscription->package->name,
							"package_price" => $payment->subscription->package->value
						], function($message) use ($payment){
	            $message->to($payment->subscription->person->email, $payment->subscription->person->name)->subject(env("APP_NAME").' - Pagamento Confirmado - Inscrição #'.$payment->subscription->id.' confirmada');
	          });
					}
					if($payment->paymentStatus ==  0){
	          Mail::send('mail.PaymentCanceled',
						[
							"subscription_id" => $payment->subscription->id,
							"person_name" => $payment->subscription->person->name,
							"package_name" => $payment->subscription->package->name,
							"package_price" => $payment->subscription->package->value
						], function($message) use ($payment){
	            $message->to($payment->subscription->person->email, $payment->subscription->person->name)->subject(env("APP_NAME").' - Pagamento Cancelado - Inscrição #'.$payment->subscription->id.' cancelada');
	          });
					}
				}else{
					if(strtotime($payment->created_at) < time()-(60*60*24)){
			 			$payment->paymentStatus = 0;
					}
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
		*
		*
		* Se $force == true, se o status do pagseguro retornar nada, ele cancela a solicitação de pagamento.
	**/
	private function getStatus($status, $force = false){
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
				if($force){
			 		return 0;
				}
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


				if($payment->statusPayment == 0){
					Mail::send('mail.PaymentCanceled',
					[
						"subscription_id" => $payment->subscription->id,
						"person_name" => $payment->subscription->person->name,
						"package_name" => $payment->subscription->package->name,
						"package_price" => $payment->subscription->package->value
					], function($message) use ($payment){
						$message->to($payment->subscription->person->email, $payment->subscription->person->name)->subject(env("APP_NAME").' - Pagamento Cancelado - Inscrição #'.$payment->subscription->id.' cancelada');
					});
				}elseif($payment->statusPayment == 2){
					Mail::send('mail.PaymentPending',
					[
						"subscription_id" => $payment->subscription->id,
						"person_name" => $payment->subscription->person->name,
						"package_name" => $payment->subscription->package->name,
						"package_price" => $payment->subscription->package->value
					], function($message) use ($payment){
						$message->to($payment->subscription->person->email, $payment->subscription->person->name)->subject(env("APP_NAME").' - Pagamento Pendente - Inscrição #'.$payment->subscription->id.' pendente');
					});
				}elseif($payment->statusPayment == 3){
					Mail::send('mail.PaymentConfirmed',
					[
						"subscription_id" => $payment->subscription->id,
						"person_name" => $payment->subscription->person->name,
						"package_name" => $payment->subscription->package->name,
						"package_price" => $payment->subscription->package->value
					], function($message) use ($payment){
						$message->to($payment->subscription->person->email, $payment->subscription->person->name)->subject(env("APP_NAME").' - Pagamento Confirmado - Inscrição #'.$payment->subscription->id.' confirmada');
					});
				}

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



	/*
	 * Private functions - Admin
	 */

 	 public function confirmSubscription($Person_id, $Payment_id){
 		 $adminController = new AdminController;
 		 $person_user = $adminController->getPerson();
 		 $payment = Payment::find($Payment_id);
 		 if($payment){
 			 if($payment->paymentStatus == 2 || $payment->paymentStatus == 1){
 				 $paymentLog = new PaymentUpdateLog;
 				 $paymentLog->User_id = $person_user->user->id;
 				 $paymentLog->Payment_id = $Person_id;
 				 $paymentLog->from = $Payment_id;
 				 $paymentLog->to = 3;
 				 $paymentLog->save();
 				 $payment->paymentStatus = 3;
 				 $payment->save();
 				 return redirect()->back();
 			 }
 		 }
 		 return redirect()->back();
 	 }
 	 public function cancelSubscription($Person_id, $Payment_id){
 		 $adminController = new AdminController;
 		 $person_user = $adminController->getPerson();
 		 $payment = Payment::find($Payment_id);
 		 if($payment){
 			 if($payment->paymentStatus == 2 || $payment->paymentStatus == 1){
 				 $paymentLog = new PaymentUpdateLog;
 				 $paymentLog->User_id = $person_user->user->id;
 				 $paymentLog->Payment_id = $payment->id;
 				 $paymentLog->from = $payment->paymentStatus;
 				 $paymentLog->to = 0;
 				 $paymentLog->save();
 				 $payment->paymentStatus = 0;
 				 $payment->save();
 				 return redirect()->back();
 			 }
 		 }
 		 return redirect()->back();
 	 }


}
