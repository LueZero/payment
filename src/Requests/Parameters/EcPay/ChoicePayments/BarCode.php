<?php

namespace Zero\Requests\Parameters\EcPay\ChoicePayments;

use Zero\Requests\Parameters\EcPay\ChoicePayments\Base;

class BarCode extends Base
{
   /**
     * @var int 
     */
    public $StoreExpireDate;

    /**
     * @var string
     */
    public $PaymentInfoURL;

    /**
     * @var string
     */
    public $ClientRedirectURL;
}
