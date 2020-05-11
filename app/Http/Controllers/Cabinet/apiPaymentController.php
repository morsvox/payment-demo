<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;

use App\User;

use Payment;
use App\Services\Payment\Implementation\PaymentCallbackModel;
use App\Services\Payment\Implementation\PaymentCallbackSoap;
use App\Services\Payment\Implementation\PaymentCallbackOfd;

class apiPaymentController 
{
	private $payment;

	function __construct()
	{
		$this->payment = Payment::getPayment();
	}

	public function postParams(Request $request)
	{
		$user = User::find($request->token);
        $this->payment->setAmount($request->amount);
		$this->payment->setOrderId($request->id);
		$this->payment->setEmail($user->login);
		
		return response()->json(["url" => $this->payment->generateUrl()]);
	}

	public function setCallback(Request $request)
	{
		$this->payment->setCallback(new PaymentCallbackModel(), $request->all());
		$this->payment->setCallback(new PaymentCallbackSoap(), $request->all());
		$this->payment->setCallback(new PaymentCallbackOfd(), $request->all());
	}

}