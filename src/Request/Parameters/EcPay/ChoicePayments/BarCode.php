<?php

namespace Zero\Request\Parameters\EcPay\ChoicePayments;

use Zero\Request\Parameters\EcPay\ChoicePayments\Base;

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
