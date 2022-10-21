<?php

namespace Zero\Requests\Parameters\EcPay\ChoicePayments;

class Base
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
    public $MerchantTradeDate;

    /**
     * @var string
     */
    public $PaymentType;

    /**
     * @var int
     */
    public $TotalAmount;

    /**
     * @var string
     */
    public $TradeDesc;

    /**
     * @var string
     */
    public $ItemName;

    /**
     * @var string
     */
    public $ReturnURL;

    /**
     * @var string
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
     * @var string
     */
    public $CheckMacValue;

    /**
     * @var int
     */
    public $EncryptType;

    /**
     * @var string
     */
    public $StoreID;

    /**
     * @var string
     */
    public $ClientBackURL;

    /**
     * @var string
     */
    public $ItemURL;

    /**
     * @var string
     */
    public $Remark;

    /**
     * @var string
     */
    public $ChooseSubPayment;

    /**
     * @var string
     */
    public $OrderResultURL;

    /**
     * @var string 
     */
    public $NeedExtraPaidInfo;

    /**
     * @var string
     */
    public $IgnorePayment;

    /**
     * @var string
     */
    public $PlatformID;

    /**
     * @var string
     */
    public $CustomField1;

    /**
     * @var string
     */
    public $CustomField2;

    /**
     * @var string
     */
    public $CustomField3;

    /**
     * @var string
     */
    public $CustomField4;

    /**
     * @var string
     */
    public $Language;
}
