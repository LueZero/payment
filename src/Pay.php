<?php

namespace Zero\Pay;

use Zero\Pay\PayMethod\EcPay;
use Zero\Pay\PayMethod\LinePay;

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
                return new EcPay($className);
                break;
            case 'linepay':
                return new LinePay($className);
                break;
            default:
                throw new \Exception('no pay method class');
        }
    }

    public function setPay($className)
    {
        switch (strtolower($className)) {
            case 'ecpay':
                $this->pay = new EcPay($className);
                break;
            case 'linepay':
                $this->pay = new LinePay($className);
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

    public function dataProcess()
    {
        $this->pay->dataProcess();
        return $this;
    }

    public function checkouts()
    {
        return $this->pay->checkouts();
    }

    public function search()
    {
        return $this->pay->search();
    }
}
