<?php

namespace Zero\Payment;

use Zero\Payment\Methods\Payment;
use Zero\Payment\Methods\EcPayment;
use Zero\Payment\Methods\LinePayment;
use Zero\Payment\Http;

class PaymentClient
{
    public array $configs;

    private Payment $payment;

    public string $paymentName;

    private array $paymentList = [
        'ec' => EcPayment::class,
        'line' => LinePayment::class
    ];

    public function __construct($paymentName)
    {
        $this->paymentName = $paymentName;
        $this->requireConfig();
        $this->setPayment();
        $this->setConfig();
    }
    
    /**
     * 設定支付
     */
    public function setPayment()
    {
        if (!array_key_exists($this->paymentName, $this->paymentList))
            throw new \Exception('no payment method class');

        $this->payment = new $this->paymentList[$this->paymentName](new Http());
    }

    /**
     * 取得支付
     */
    public function getPayment(): Payment
    {
        return $this->payment;
    }

    /**
     * 改變支付
     */
    public function changePay($paymentName)
    {
        $this->paymentName = $paymentName;
        $this->setPayment();
    }

    /**
     * 呼叫配置檔
     */
    private function requireConfig()
    {
        $configs = require('config.php');

        if(empty($configs[$this->paymentName]))
            throw new \Exception('config is empty');

        $this->configs = $configs[$this->paymentName];
    }

    /**
     * 設定配置檔
     */
    public function setConfig()
    {
        $this->payment->setParameters($this->configs);
    }

    // 保留
    // public static function __callStatic($value, $args)
    // {
    //     return static::$locale::$$value;
    // }
}
