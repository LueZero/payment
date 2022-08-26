<?php

namespace Zero\Request\Parameters\LinePay;

class Confirm
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
    public static function CreateConfirm()
    {
        return new Confirm();
    }
}
