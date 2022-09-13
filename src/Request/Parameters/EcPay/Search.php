<?php

namespace Zero\Request\Parameters\EcPay;

class Search
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
     * @var int
     */
    public $TimeStamp;

    /**
     * @var string
     */
    public $CheckMacValue;

    /**
     * @var string
     */
    public $PlatformID;

    /**
     * 搜尋資料
     * @return Search
     */
    public static function createSearch()
    {
        return new Search();
    }
}
