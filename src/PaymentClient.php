<?php

namespace Zero;

use Zero\Helpers\DataCheck;
use Zero\Payments\Payment;
use Zero\Payments\EcPayment;
use Zero\Payments\LinePayment;

class PaymentClient
{
    /**
     * class Payment
     */
    private $payment;

    /**
     * array configs
     */
    public $configs;

    /**
     * string paymentName
     */
    public $paymentName;

    /**
     * array paymentNames
     */
    public $paymentNames = [
        'ec' => 'EcPayment',
        'line' => 'LinePayment'
    ];

    /**
     * array paymentList
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
     * void 設定支付
     */
    public function setPayment()
    {
        if (!array_key_exists($this->paymentName, $this->paymentNames))
            throw new \Exception('Zero\Payment\PaymentClient::[no payment method class]');

        $this->payment = new $this->paymentList[$this->paymentName](new Http());
    }

    /**
     * void 
     */
    public function setPaymentConfigs()
    {
        $this->payment->setConfigs($this->configs);
    }

    /**
     * return class Payment 取得支付
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * void 改變支付
     */
    public function changePayment($paymentName)
    {
        $this->paymentName = $paymentName;
        $this->setPayment();
    }

    /**
     * return array 呼叫配置檔
     */
    private function requireConfig()
    {
        $configs = require('config.php');

        if (empty($configs[$this->paymentName]))
            throw new \Exception('Zero\Payment\PaymentClient::[payment config is empty]');

        $this->configs = $configs[$this->paymentName];
    }

    /**
     * return class Payment 設定請求參數
     */
    public function setRequestParameters(array $requestParameters)
    {
        return $this->payment->setRequestParameters($requestParameters);
    }
}
