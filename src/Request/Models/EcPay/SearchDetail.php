<?php

namespace Zero\Request\Models\EcPay;

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
}
