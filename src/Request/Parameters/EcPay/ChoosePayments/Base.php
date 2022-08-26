<?php

namespace Zero\Request\Parameters\EcPay\ChoosePayments;

class Base
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
     * --------------------
     * Credit：信用卡及銀聯卡(需申請開通)
     * WebATM：網路ATM
     * ATM：自動櫃員機
     * CVS：超商代碼
     * BARCODE：超商條碼
     * ApplePay: Apple Pay(僅支援手機支付)
     * ALL：不指定付款方式，由綠界顯示付款方式選擇頁面。
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
     * string itemURL
     */
    public $ItemURL;

    /**
     * string remark
     */
    public $Remark;

    /**
     * string chooseSubPayment
     */
    public $ChooseSubPayment;

    /**
     * string orderResultURL
     */
    public $OrderResultURL;

    /**
     * string needExtraPaidInfo 
     */
    public $NeedExtraPaidInfo;

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
