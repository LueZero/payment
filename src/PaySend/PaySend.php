<?php

namespace Zero\Pay\PaySend;

use Exception;
use Zero\Pay\PaySend\EcPaySend;
use Zero\Pay\PaySend\LinePaySend;

class PaySend
{
    public static function setUp($className)
    {
        switch (strtolower($className)) {
          case 'ecpay':
            return new EcPaySend();
            break;
          case 'linepay':
            return new LinePaySend();
            break;
          default:
            throw new Exception('no pay send object');
        }
    }

    // public static function __callStatic($value, $args)
    // {
    //     return static::$locale::$$value;
    // }
}