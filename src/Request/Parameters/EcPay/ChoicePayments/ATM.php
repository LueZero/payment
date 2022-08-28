<?php

namespace Zero\Request\Parameters\EcPay\ChoicePayments;

use Zero\Request\Parameters\EcPay\ChoicePayments\Base;

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
