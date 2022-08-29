<?php

namespace Zero\Request\Parameters\LinePay;

class Checkouts
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
     * string orderId
     */
    public $orderId;

    /**
     * array packages
     */
    public $packages;

    /**
     * array redirectUrls
     */
    public $redirectUrls;

    /**
     * int refundAmount
     */
    public $refundAmount;

    /**
     * array options
     */
    public $options;

    /**
     * 結帳
     */
    public static function createCheckouts()
    {
        return new Checkouts();
    }
}
