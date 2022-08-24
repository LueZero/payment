<?php

namespace Zero\Request\Models\EcPay;

class Search
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
     * int timeStamp
     */
    public $TimeStamp;

    /**
     * string checkMacValue
     */
    public $CheckMacValue;

    /**
     * string platformID
     */
    public $PlatformID;
}
