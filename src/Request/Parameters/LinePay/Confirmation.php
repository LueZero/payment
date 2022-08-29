<?php

namespace Zero\Request\Parameters\LinePay;

class Confirmation 
{
    /**
     * int amount
     */
    public $amount;

    /**
     * string currency
     */
    public $currency;

    /**
     * 確認
     */
    public static function createConfirmation()
    {
        return new Confirmation();
    }
}
