<?php

namespace Zero\Requests\Parameters\EcPay\ChoicePayments;

use Zero\Requests\Parameters\EcPay\ChoicePayments\Base;

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
