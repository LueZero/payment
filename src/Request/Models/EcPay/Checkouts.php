<?php

namespace Zero\Request\Models\EcPay;

class Checkouts
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
     * string merchantTradeDate
     */
    public $MerchantTradeDate;

    /**
     * string paymentType
     */
    public $PaymentType;

    /**
     * int totalAmount
     */
    public $TotalAmount;

    /**
     * string tradeDesc
     */
    public $TradeDesc;

    /**
     * string itemName
     */
    public $ItemName;

    /**
     * string returnURL
     */
    public $ReturnURL;

    /**
     * string choosePayment
     */
    public $ChoosePayment;

    /**
     * string checkMacValue
     */
    public $CheckMacValue;

    /**
     * int encryptType
     */
    public $EncryptType;

    /**
     * string storeID
     */
    public $StoreID;

    /**
     * string clientBackURL
     */
    public $ClientBackURL;

    /**
     * string remark
     */
    public $Remark;

    /**
     * string orderResultURL
     */
    public $OrderResultURL;

    /**
     * string ignorePayment
     */
    public $IgnorePayment;

    /**
     * string platformID
     */
    public $PlatformID;

    /**
     * string customField1
     */
    public $CustomField1;

    /**
     * string customField2
     */
    public $CustomField2;

    /**
     * string customField3
     */
    public $CustomField3;

    /**
     * string customField4
     */
    public $CustomField4;

    /**
     * string language
     */
    public $Language;
}
