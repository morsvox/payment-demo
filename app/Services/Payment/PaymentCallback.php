<?php

namespace App\Services\Payment;

abstract class PaymentCallback
{
    abstract public function save(array $request);
}