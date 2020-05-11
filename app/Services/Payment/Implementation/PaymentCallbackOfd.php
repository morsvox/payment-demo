<?php

namespace App\Services\Payment\Implementation;

use App\Services\Payment\PaymentCallback;
use App\Services\Integration\Ofd;

use Log;

class PaymentCallbackOfd extends PaymentCallback
{
    public function save(array $request)
    {
		if($request["success"]) {
            $ofd = new Ofd;
            $ofd->setCheck(
                $request["email"], 
                $request["order"], 
                $request["amount"]
            );
		}
    }
}