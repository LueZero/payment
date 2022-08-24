<?php

namespace Zero\Request\Models\EcPay;

class Refund
{
    /**
     * string merchantID
     */
    public $MerchantID;

    /**
     * string merchantTradeNo
     */
    public $MerchantTradeNo;

    /**
     * string tradeNo
     */
    public $TradeNo;

    /**
     * string action
     */
    public $Action;

    /**
     * int totalAmount
     */
    public $TotalAmount;

    /**
     * string checkMacValue
     */
    public $CheckMacValue;

    /**
     * string platformID
     */
    public $PlatformID;
}
