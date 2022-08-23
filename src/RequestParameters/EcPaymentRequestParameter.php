<?php

namespace Zero\RequestParameters;

class EcPaymentRequestParameter
{
    /**
     * string merchantID
     */
    public $merchantID;

    /**
     * string merchantTradeNo
     */
    public $merchantTradeNo;

    /**
     * string merchantTradeDate
     */
    public $merchantTradeDate;

    /**
     * string totalAmount
     */
    public $totalAmount;

    /**
     * string tradeDesc
     */
    public $tradeDesc;

    /**
     * string itemName
     */
    public $itemName;

    /**
     * string returnURL
     */
    public $returnURL;

    /**
     * string paymentType
     */
    public $paymentType;

    /**
     * string choosePayment
     */
    public $choosePayment;

    /**
     * string encryptType
     */
    public $encryptType;

    /**
     * string timeStamp
     */
    public $timeStamp;
}
