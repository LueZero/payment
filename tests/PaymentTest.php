<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Zero\PaymentClient as PaymentClient;

final class PaymentTest extends TestCase
{
    /**
     * @test
     */
    public function Given_Ec_When_CreatePayment_Then_Return_EcPayment(): void
    {
        $paymentClient = new PaymentClient('ec');
        $this->assertStringStartsWith('Zero\Payment\Methods\EcPayment', get_class($paymentClient->getPayment()));
    }

    /**
     * @test
     */
    public function Given_Line_When_CreatePayment_Then_Return_LinePayment(): void
    {
        $paymentClient = new PaymentClient('line');
        $this->assertStringStartsWith('Zero\Payment\Methods\LinePayment', get_class($paymentClient->getPayment()));
    }

    /**
     * @test
     */
    public function Given_Zero_When_CreatePayment_Then_Throw_Exception()
    {
        $this->expectException(Exception::class);
        $paymentClient = new PaymentClient('zero');
    }
}
