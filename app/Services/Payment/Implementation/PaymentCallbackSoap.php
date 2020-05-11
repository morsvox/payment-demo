<?php

namespace App\Services\Payment\Implementation;

use App\Services\Payment\PaymentCallback;
use App\Jobs\SoapSendMethod;

use Log;

class PaymentCallbackSoap extends PaymentCallback
{
    public function save(array $request)
    {
        $params = [
            "ORDER" => $request["order"],
            "AMOUNT" => $request["amount"],
            "TIMESTAMP" => date('d.m.Y H:i:s'),
            "RESULT" => $request["code"],
            "RCTEXT" => $request["result"]
        ];
        SoapSendMethod::dispatch($params);

        Log::debug("1c payment save", ["result" => $result]);
    }
}