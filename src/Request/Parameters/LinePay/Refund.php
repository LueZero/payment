<?php

namespace Zero\Request\Parameters\LinePay;

class Refund
{
    /**
     * @var int
     */
    public $refundAmount;

    /**
     * @var object
     */
    public $options;

    /**
     * 退款
     * @return Refund
     */
    public static function createRefund()
    {
        return new Refund();
    }
}
