<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Zero\PaymentClient as PaymentClient;

final class PaymentTest extends TestCase
{
    private static $configPath;
    private static $createdConfig = false;

    public static function setUpBeforeClass(): void
    {
        self::$configPath = dirname(__DIR__) . '/src/config.php';

        if (!file_exists(self::$configPath)) {
            self::$createdConfig = copy(dirname(__DIR__) . '/src/config.example.php', self::$configPath);
        }
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$createdConfig && self::$configPath && file_exists(self::$configPath)) {
            unlink(self::$configPath);
        }
    }

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

    /**
     * @test
     */
    public function Given_RequestParameters_When_SetTwice_Then_ReplacePreviousData(): void
    {
        $paymentClient = new PaymentClient('line');
        $payment = $paymentClient->createPayment();

        $payment->setRequestParameter([
            'orderId' => '20220821103746',
            'unused' => 'old',
        ]);

        $payment->setRequestParameter([
            'orderId' => '20220821103747',
        ]);

        $this->assertSame([
            'orderId' => '20220821103747',
        ], $payment->getSendingData());
    }
}
