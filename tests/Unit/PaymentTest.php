<?php

namespace Tests\Unit;

use Tests\TestCase;
use Payment;

class PaymentTest extends TestCase
{
    public function testPayment()
    {
        $amount = 1.22;
        
        $payment = Payment::getPayment();
        $payment->setAmount($amount);
        $payment->setOrderId("123123");
        $payment->setEmail("test@test.com");

        $this->assertTrue($payment->getAmount() === $amount);
        $this->assertIsString($payment->generateUrl());
    }
}
