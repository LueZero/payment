<?php

namespace Zero\Request\Parameters\EcPay;

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

    /**
     * 搜尋資料
     */
    public static function createSearch()
    {
        return new Search();
    }
}
