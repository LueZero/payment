<?php

namespace Zero\Requests\Parameters\EcPay\ChoicePayments;

use Zero\Request\Parameters\EcPay\ChoicePayments\Base;

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
