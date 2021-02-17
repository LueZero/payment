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

    /**
     * 設定支付 靜態
     */
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

    /**
     * 設定支付 實例
     */
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

    /**
     * 請求參數
     */
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
    public function refund($orderId=null)
    {
        return $this->pay->refund($orderId);
    }

    // 保留
    // public static function __callStatic($value, $args)
    // {
    //     return static::$locale::$$value;
    // }
}
