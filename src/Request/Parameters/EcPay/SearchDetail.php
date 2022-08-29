<?php

namespace Zero\Request\Parameters\EcPay;

class SearchDetail
{
    /**
     * string merchantID
     */
    public $MerchantID;

    /**
     * int creditRefundId
     */
    public $CreditRefundId;

    /**
     * int creditAmount
     */
    public $CreditAmount;

    /**
     * int creditCheckCode
     */
    public $CreditCheckCode;

    /**
     * string checkMacValue
     */
    public $CheckMacValue;

    /**
     * 搜尋單筆明細資料記錄
     */
    public static function createDetail()
    {
        return new SearchDetail();
    }
}
