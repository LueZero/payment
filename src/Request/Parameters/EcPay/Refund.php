<?php

namespace Zero\Request\Parameters\EcPay;

class Refund
{
    /**
     * @var string
     */
    public $MerchantID;

    /**
     * @var string
     */
    public $MerchantTradeNo;

    /**
     * @var string
     */
    public $TradeNo;

    /**
     * @var string
     */
    public $Action;

    /**
     * @var int
     */
    public $TotalAmount;

    /**
     * @var string
     */
    public $CheckMacValue;

    /**
     * @var string
     */
    public $PlatformID;
    
    /**
     * @return Refund
     */
    public static function createRefund()
    {
        return new Refund();
    }
}
