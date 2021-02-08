<?php

namespace Zero\Pay;

use Exception;
use Zero\Pay\PayMethod\EcPay;
use Zero\Pay\PayMethod\JkosPay;
use Zero\Pay\PayMethod\LinePay;

class Payment
{
    private $method;

    public function __construct($methodName, $parameter)
    {
        $this->setUp($methodName);
        $this->setParameter($parameter);
    }

    public function setUp($methodName)
    {
        switch ($methodName) {
            case 'ecPay':
                $this->method = new EcPay($methodName);
                break;
            case 'linePay':
                $this->method = new LinePay($methodName);
                break;
            default :
                throw new Exception('no pay method class');
        }
    }

    public function setParameter($parameter)
    {
        array_walk($parameter, array($this, 'setLoopParameter'));
    }

    public function setLoopParameter($value, $index)
    {
        if(property_exists($this->method, $index)){
            $this->method->$index = $value;
        }
    }

    public function createOrder($requestsData)
    {
        return $this->method->createOrder($requestsData);
    }

    public function searchOrder($requestsData)
    {
        return $this->method->searchOrder($requestsData);
    }

    public function confirm($requestsData)
    {
        return $this->method->confirm($requestsData);
    }

    public function result()
    {
        return $this->method->result();
    }

    public function dataProcess()
    {
        return $this->method->dataProcess();
    }

    public function checkOut()
    {
        return $this->method->checkOut();
    }
}
