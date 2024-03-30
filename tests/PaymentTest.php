<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Zero\PaymentClient as PaymentClient;

final class PaymentTest extends TestCase
{
    /**
     * @test
     */
    public function Given_EC_When_CreatePayment_Then_Return_ECPayment(): void
    {
        $paymentClient = new PaymentClient('ec');
        $payment = $paymentClient->createPayment();
        $this->assertStringStartsWith('Zero\Payments\ECPayment', get_class($payment));
    }

    /**
     * @test
     */
    public function Given_LINE_When_CreatePayment_Then_Return_LINEPayment(): void
    {
        $paymentClient = new PaymentClient('line');
        $payment = $paymentClient->createPayment();
        $this->assertStringStartsWith('Zero\Payments\LINEPayment', get_class($payment));
    }

    /**
     * @test
     */
    public function Given_Zero_When_CreatePayment_Then_Throw_Exception()
    {
        $this->expectException(\Exception::class);
        $paymentClient = new PaymentClient('zero');
        $payment = $paymentClient->createPayment();
    }
}
