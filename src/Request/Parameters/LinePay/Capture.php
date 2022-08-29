<?php

namespace Zero\Request\Parameters\LinePay;

class Capture
{
    /**
     * int amount
     */
    public $amount;

    /**
     * string currency
     */
    public $currency;

    /**
     * object options
     */
    public $options;

    /**
     * 捕獲
     */
    public static function createCapture()
    {
        return new Capture();
    }
}
