<?php

namespace Zero\Pay;

use Exception;
use Zero\Pay\PayMethod\EcPay;
use Zero\Pay\PayMethod\LinePay;

class Pay
{
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
}
