<?php

namespace Zero;

use Zero\Helpers\DataChecker;
use Zero\Payments\Payment;
use Zero\Payments\ECPayment;
use Zero\Payments\LINEPayment;

class PaymentClient
{
    /**
     * @var string
     */
    public $paymentName;

    /**
     * @var array
     */
    public $paymentNames = [
        'ec' => 'ECPayment',
        'line' => 'LINEPayment'
    ];

    /**
     * @var array
     */
    private $paymentList = [
        'ec' => ECPayment::class,
        'line' => LINEPayment::class
    ];

    public function __construct($paymentName)
    {
        $this->paymentName = $paymentName;
    }

    /**
     * @return Payment
     * @throws \Exception
     */
    public function createPayment()
    {
        if (!array_key_exists($this->paymentName, $this->paymentNames))
            throw new \Exception('Zero\Payment\PaymentClient::[no payment method class]');

        return new $this->paymentList[$this->paymentName](new Http());
    }
}
