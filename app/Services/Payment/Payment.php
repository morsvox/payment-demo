<?php

namespace App\Services\Payment;

use App\Services\Payment\PaymentCallback;

abstract class Payment
{
    protected $params = [];
    protected $baseurl;
    protected $checkEmail;
    protected static $connection;
    
    public static function getPayment() : Payment
    {
        self::getConnection();
        $instance = self::createInstance();
        return $instance;
    }

    public function getBaseUrl() : string
    {
        return $this->baseurl;
    }

    public function getParams() : array
    {
        return $this->params; 
    }

    protected static function getConnection()
    {
        $conn = config('payment.connections');
        self::$connection = $conn[config('payment.default')];
    }

    protected static function createInstance()
    {
        $instance = new self::$connection['implementation'];
        $instance->setParams();
        return $instance;
    }

    abstract public function generateUrl() : string;
    abstract protected function setParams();
    abstract public function setAmount(float $amount);
    abstract public function setOrderId(string $id);
    abstract public function setEmail(string $email);
    abstract public function getAmount() : float;

    abstract public function setCallback(PaymentCallback $callback, array $request);

}