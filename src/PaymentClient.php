<?php

namespace Zero;

use Zero\Helpers\DataChecker;
use Zero\Payments\Payment;
use Zero\Payments\EcPayment;
use Zero\Payments\LinePayment;

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
        'ec' => 'EcPayment',
        'line' => 'LinePayment'
    ];

    /**
     * @var array
     */
    private $paymentList = [
        'ec' => EcPayment::class,
        'line' => LinePayment::class
    ];

    public function __construct($paymentName)
    {
        $this->paymentName = $paymentName;
    }

    /**
     * @return Payment
     */
    public function createPayment()
    {
        if (!array_key_exists($this->paymentName, $this->paymentNames))
            throw new \Exception('Zero\Payment\PaymentClient::[no payment method class]');

        return new $this->paymentList[$this->paymentName](new Http());
    }

    /**
     * @return Payment 
     */
    public function setRequestParameters(array $requestParameters)
    {
        return $this->payment->setRequestParameters($requestParameters);
    }
}
