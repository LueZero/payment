<?php

namespace Zero\Requests\Parameters\ECPay\ChoicePayments;

use Zero\Requests\Parameters\ECPay\ChoicePayments\Base;

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
