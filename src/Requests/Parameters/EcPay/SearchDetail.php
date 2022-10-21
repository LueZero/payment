<?php

namespace Zero\Requests\Parameters\EcPay;

class SearchDetail
{
    /**
     * @var string
     */
    public $MerchantID;

    /**
     * @var int
     */
    public $CreditRefundId;

    /**
     * @var int
     */
    public $CreditAmount;

    /**
     * @var int
     */
    public $CreditCheckCode;

    /**
     * @var string
     */
    public $CheckMacValue;

    /**
     * 搜尋單筆明細資料記錄
     * @return SearchDetail
     */
    public static function createSearchDetail()
    {
        return new SearchDetail();
    }
}
