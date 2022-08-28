<?php

namespace Zero\Request\Parameters\EcPay\ChoicePayments;

use Zero\Request\Parameters\EcPay\ChoicePayments\Base;

class CVS extends Base
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

    /**
     * string desc 1 
     */
    public $Desc_1;

    /**
     * string desc 2 
     */
    public $Desc_2;

    /**
     * string desc 3
     */
    public $Desc_3;

    /**
     * string desc 4
     */
    public $Desc_4;
}
