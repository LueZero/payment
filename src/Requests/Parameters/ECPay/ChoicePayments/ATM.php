<?php

namespace Zero\Requests\Parameters\ECPay\ChoicePayments;

use Zero\Requests\Parameters\ECPay\ChoicePayments\Base;

class ATM extends Base
{
    /**
     * @var int
     */
    public $ExpireDate;

    /**
     * @var string
     */
    public $PaymentInfoURL;

    /**
     * @var strung 
     */
    public $ClientRedirectURL;
}
