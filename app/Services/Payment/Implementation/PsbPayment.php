<?php

namespace App\Services\Payment\Implementation;

use App\Services\Payment\Payment;
use App\Services\Payment\PaymentCallback;
use App\Services\Payment\Implementation\PaymentCallbackModel;
use Log;

class PsbPayment extends Payment
{

    public function generateUrl() : string
    {
        $this->params['P_SIGN'] = $this->generateKey($this->params, 'AMOUNT,CURRENCY,ORDER,MERCH_NAME,MERCHANT,TERMINAL,EMAIL,TRTYPE,TIMESTAMP,NONCE,BACKREF');
        return $this->getBaseUrl().'?'.http_build_query($this->getParams());
    }

    public function setAmount(float $amount)
    {
        $this->params['AMOUNT'] = $amount;
    }

    public function getAmount() : float
    {
        return $this->params['AMOUNT'];
    }

    public function setOrderId(string $id)
    {
        $this->params['ORDER'] = $this->makeOrder($id);
        $this->params['DESC'] = "Order ".$this->params['ORDER'];
    }

    public function setEmail(string $email)
    {
        $this->params['EMAIL'] = $email;
    }

    public function setCallback(PaymentCallback $callback, array $request)
    {
        $result = [
            "success" => $request["RESULT"]==0?true:false,
            "order" => $request["ORDER"],
            "amount" => $request["AMOUNT"],
            "timestamp" => $request["TIMESTAMP"],
            "code" => $request["RESULT"],
            "email" => $request["EMAIL"],
            "result" => $request["RCTEXT"]
        ];
        $callback->save($result);
    }

    protected function setParams()
    {
        $this->baseurl = self::$connection['baseurl'];
        $this->params = self::$connection['params'];
        $this->params['CURRENCY'] = 'RUB';
        $this->params['TIMESTAMP'] = date('YmdHis', time() - 4 * 3600);
        $this->params['BACKREF'] = route("backref");
        $r = base_convert(mt_rand(), 10, 16);
        $p = base_convert(mt_rand(), 10, 16);
        $this->params['NONCE'] = strtoupper($r . $p);
    }

    protected function generateKey($d, $params) 
    {
        $arr = explode(',', $params);
        $str = '';
        foreach ($arr as $v) {
            $s = strval($d[$v]);
            if ($s != '') {
                $str = $str . strlen($s) . $s;
            } else {
                $str = $str . '-';
            }
        }
        $key = pack('H*', 'KEY');
        $hmac = hash_hmac('sha1', $str, $key);
        return $hmac;
    }

    private function makeOrder($str)
    {
        if (strlen($str) < 6) {
            $str = str_repeat('0', 6 - strlen($str)) . $str;
        }
        return $str;
    }

}