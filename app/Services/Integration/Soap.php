<?php

namespace App\Services\Integration;

abstract class Soap
{

    protected static function getInstance()
    {
        return new \SoapClient(
            config('soap.connections.ut.host'), 
            [
                "login" => config('soap.connections.ut.login'), 
                "password" => config('soap.connections.ut.password')
            ]
        );
    }

    public static function send(array $data) 
    {
    	$soap = self::getInstance();
		$result = $soap->SetPay($data);
    	return $result->return;
    }
}