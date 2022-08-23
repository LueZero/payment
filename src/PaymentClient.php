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
    private $configs;

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
    }

    /**
     * void 設定支付
     */
    public function setPayment()
    {
        if (!array_key_exists($this->paymentName, $this->paymentNames))
            throw new \Exception('Zero\Payment\PaymentClient::[no payment method class]');

        $this->payment = new $this->paymentList[$this->paymentName](new Http());
        $configs = $this->requireConfig();
        $this->payment->setParameters($configs);
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

        return $configs[$this->paymentName];
    }

    // 保留
    // public static function __callStatic($value, $args)
    // {
    //     return static::$locale::$$value;
    // }
}
