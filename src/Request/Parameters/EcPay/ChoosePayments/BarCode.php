<?php

namespace Zero\Request\Parameters\EcPay\ChoosePayments;

use Zero\Request\Parameters\EcPay\ChoosePayments\Base;

class BarCode extends Base
{
   /**
     * int storeExpireDate 
     */
    public $StoreExpireDate;

    /**
     * string paymentInfoURL
     */
    public $PaymentInfoURL;

    /**
     * string clientRedirectURL
     */
    public $ClientRedirectURL;
}
