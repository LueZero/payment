<?php

namespace Zero\Pay;

use Exception;
use Zero\Pay\PayMethod\EcPay;
use Zero\Pay\PayMethod\LinePay;

class Pay
{
    public $classPay;
    
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
                throw new Exception('no pay method class');
        }
    }

    public function setPay($className)
    {   
        switch (strtolower($className)) {
            case 'ecpay':
                $this->classPay = new EcPay($className);
                break;
            case 'linepay':
                $this->classPay = new LinePay($className);
                break;
            default:
                throw new Exception('no pay method class');
        }
    }
    
    public function requestParameter($data)
    {
        $this->classPay->requestParameter($data);
        return $this;
    }

    public function dataProcess()
    {
        $this->classPay->dataProcess();
        return $this;
    }

    public function checkouts()
    {
        return $this->classPay->checkouts();
    }

    public function search()
    {
        return $this->classPay->search();
    }
}
