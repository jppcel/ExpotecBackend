<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{

	public function searchPendingPayments(){
		 $payments = Payment::where(["paymentStatus" => 1])->orWhere(["paymentStatus" => 2])->get();

		 foreach($payments as $payment){
		 		$response = searchByReference($payment);
		 }
	}

	private function searchByReference(Payment $payment){
		$options = [
	    'initial_date' => $payment->created_at
		];

		try {
	    $response = \PagSeguro\Services\Transactions\Search\Reference::search(
        \PagSeguro\Configuration\Configure::getAccountCredentials(),
        $payment->Transaction_id,
        $options
	    );

    	return $response;

		} catch (Exception $e) {
	    die($e->getMessage());
		}
	}
}
