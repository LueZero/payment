<?php

namespace Zero;

use Zero\Helpers\DataCheck;
use Zero\Payments\Payment;
use Zero\Payments\EcPayment;
use Zero\Payments\LinePayment;

class PaymentClient
{
    /**
     * @var Payment
     */
    private $payment;

    /**
     * @var array
     */
    public $configs;

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
        $this->setPayment();
        $this->requireConfig();
        $this->setPaymentConfigs();
    }

    /**
     * 設定支付
     */
    public function setPayment()
    {
        if (!array_key_exists($this->paymentName, $this->paymentNames))
            throw new \Exception('Zero\Payment\PaymentClient::[no payment method class]');

        $this->payment = new $this->paymentList[$this->paymentName](new Http());
    }

    /**
     * 設定支付配置 
     */
    public function setPaymentConfigs()
    {
        $this->payment->setConfigs($this->configs);
    }

    /**
     * @return Payment 支付
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * 改變支付
     */
    public function changePayment($paymentName)
    {
        $this->paymentName = $paymentName;
        $this->setPayment();
    }

    /**
     * 呼叫配置檔案
     */
    private function requireConfig()
    {
        $configs = require('config.php');

        if (empty($configs[$this->paymentName]))
            throw new \Exception('Zero\Payment\PaymentClient::[payment config is empty]');

        $this->configs = $configs[$this->paymentName];
    }

    /**
     * 設定請求參數
     * @return Payment 
     */
    public function setRequestParameters(array $requestParameters)
    {
        return $this->payment->setRequestParameters($requestParameters);
    }
}
