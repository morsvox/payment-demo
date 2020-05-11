<?php

namespace App\Services\Payment\Implementation;

use App\Services\Payment\PaymentCallback;
use App\Models\Cabinet\Payment\Payment;

class PaymentCallbackModel extends PaymentCallback
{
    public function save(array $request)
    {
        Payment::create([
            "amount" => $request["amount"],
            "order" => $request["order"],
            "result" => $request["success"].' : '.$request["result"]
        ]);
    }
}