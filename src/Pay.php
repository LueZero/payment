<?php

namespace Zero\Pay;

use Zero\Pay\PayMethod\EcPay;
use Zero\Pay\PayMethod\LinePay;
use Zero\Pay\PaySend\EcPaySend;
use Zero\Pay\PaySend\LinePaySend;

class Pay
{
    public $pay;

    public function __construct($className)
    {
        $this->setPay($className);
    }

    public static function setUp($className)
    {
        switch (strtolower($className)) {
            case 'ecpay':
                $paySend = new EcPaySend();
                return new EcPay($className, $paySend);
                break;
            case 'linepay':
                $paySend = new LinePaySend();
                return new LinePay($className, $paySend);
                break;
            default:
                throw new \Exception('no pay method class');
        }
    }

    public function setPay($className)
    {
        switch (strtolower($className)) {
            case 'ecpay':
                $paySend = new EcPaySend();
                $this->pay = new EcPay($className, $paySend);
                break;
            case 'linepay':
                $paySend = new LinePaySend();
                $this->pay = new LinePay($className, $paySend);
                break;
            default:
                throw new \Exception('no pay method class');
        }
    }

    public function requestParameter($data)
    {
        $this->pay->requestParameter($data);
        return $this;
    }

    /**
     * 金流資料處理
     */
    public function dataProcess()
    {
        $this->pay->dataProcess();
        return $this;
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        return $this->pay->checkouts();
    }

    /**
     * 搜尋
     */
    public function search()
    {
        return $this->pay->search();
    }

    /**
     * 退款
     */
    public function refund()
    {
        return $this->pay->search();
    }

    // 保留
    // public static function __callStatic($value, $args)
    // {
    //     return static::$locale::$$value;
    // }
}
