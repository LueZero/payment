<?php

namespace Zero\Request\Parameters\LinePay;

class Capture
{
    /**
     * @var int
     */
    public $amount;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var object
     */
    public $options;

    /**
     * 捕獲
     * @return Capture
     */
    public static function createCapture()
    {
        return new Capture();
    }
}
