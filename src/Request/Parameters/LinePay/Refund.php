<?php

namespace Zero\Request\Parameters\LinePay;

class Refund
{
    /**
     * int refundAmount
     */
    public $refundAmount;

    /**
     * object options
     */
    public $options;

    /**
     * 退款
     */
    public static function CreateRefund()
    {
        return new Refund();
    }
}
