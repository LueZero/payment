<?php

namespace Zero\Request\Parameters\LinePay;

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
