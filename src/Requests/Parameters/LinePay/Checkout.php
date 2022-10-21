<?php

namespace Zero\Requests\Parameters\LinePay;

class Checkout
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
     * @return Checkout
     */
    public static function createCheckout()
    {
        return new Checkout();
    }
}
