<?php

namespace Zero\Requests\Parameters\LINEPay;

class Confirmation 
{
    /**
     * @var int
     */
    public $amount;

    /**
     * @var string
     */
    public $currency;

    /**
     * 確認
     * @return Confirmation
     */
    public static function createConfirmation()
    {
        return new Confirmation();
    }
}
