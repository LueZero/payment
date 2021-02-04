<?php

namespace Zero\Pay\PaySend;

use Exception;
use Zero\Pay\PaySend\EcPaySend;
use Zero\Pay\PaySend\LinePaySend;

class PaySend
{
    public static $set;

    public static function setUp($methodName)
    {
        switch ($methodName) {
          case 'ecPay':
            return new EcPaySend();
            break;
          case 'linePay':
            return new LinePaySend();
            break;
          default:
            throw new Exception('no pay pay send class');
        }
    }

    // public static function __callStatic($value, $args)
    // {
    //     return static::$locale::$$value;
    // }
}