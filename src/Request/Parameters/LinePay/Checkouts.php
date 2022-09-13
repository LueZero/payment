<?php

namespace Zero\Request\Parameters\LinePay;

class Checkouts
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
     * @var string
     */
    public $orderId;

    /**
     * @var array
     */
    public $packages;

    /**
     * @var array
     */
    public $redirectUrls;

    /**
     * @var int
     */
    public $refundAmount;

    /**
     * @var array
     */
    public $options;

    /**
     * 結帳
     * @return Checkouts
     */
    public static function createCheckouts()
    {
        return new Checkouts();
    }
}
