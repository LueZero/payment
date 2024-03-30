<?php

namespace Zero\Requests\Parameters\ECPay\ChoicePayments;

use Zero\Requests\Parameters\ECPay\ChoicePayments\Base;

class CVS extends Base
{
    /**
     * @var int storeExpireDate 
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

    /**
     * @var string
     */
    public $Desc_1;

    /**
     * @var string 
     */
    public $Desc_2;

    /**
     * @var string
     */
    public $Desc_3;

    /**
     * @var string
     */
    public $Desc_4;
}
