<?php

namespace Zero\Request\Parameters\EcPay\ChoosePayments;

use Zero\Request\Parameters\EcPay\ChoosePayments\Base;

class ATM extends Base
{
    /**
     * int expireDate
     */
    public $ExpireDate;

    /**
     * string paymentInfoURL
     */
    public $PaymentInfoURL;

    /**
     * strung clientRedirectURL 
     */
    public $ClientRedirectURL;
}
