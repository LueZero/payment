<?php

namespace Zero\RequestParameters;

class LinePaymentRequestParameter
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
}
