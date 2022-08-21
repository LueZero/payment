<?php

namespace Zero\Payment\Parameters;

class EcPaymentRequestParameter
{
    public string $merchantID;

    public string $merchantTradeNo;

    public string $merchantTradeDate;

    public string $totalAmount;

    public string $tradeDesc;

    public string $itemName;

    public string $returnURL;

    public string $paymentType;

    public string $choosePayment;

    public string $encryptType;

    public string $timeStamp;
}
