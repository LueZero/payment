<?php

namespace Zero\Request\Parameters\EcPay;

use Zero\Request\Parameters\EcPay\ChoosePayments\Base;
use Zero\Request\Parameters\EcPay\ChoosePayments\Credit;
use Zero\Request\Parameters\EcPay\ChoosePayments\AppelPay;
use Zero\Request\Parameters\EcPay\ChoosePayments\ATM;
use Zero\Request\Parameters\EcPay\ChoosePayments\CVS;
use Zero\Request\Parameters\EcPay\ChoosePayments\BarCode;
use Zero\Request\Parameters\EcPay\ChoosePayments\WebATM;

class Checkouts
{
    public function __construct()
    {
    }

    public static function CreateAll()
    {
        return new Base();
    }

    /**
     * 信用卡
     */
    public static function CreateCredit()
    {
        $credit = new Credit();
        $credit->ChoosePayment = 'Credit';
        return $credit;
    }

    /**
     * Appel Pay
     */
    public static function CreateAppelPay()
    {
        $credit = new AppelPay();
        $credit->ChoosePayment = 'AppelPay';
        return $credit;
    }

    /**
     * ATM
     */
    public static function CreateATM()
    {
        $credit = new ATM();
        $credit->ChoosePayment = 'ATM';
        return $credit;
    }

    /**
     * CVS
     */
    public static function CreateCVS()
    {
        $credit = new CVS();
        $credit->ChoosePayment = 'CVS';
        return $credit;
    }

    /**
     * Barcode
     */
    public static function CreateBarcode()
    {
        $credit = new CVS();
        $credit->ChoosePayment = 'BARCODE';
        return $credit;
    }

    /**
     * WebATM
     */
    public static function CreateWebATM()
    {
        $credit = new WebATM();
        $credit->ChoosePayment = 'WebATM';
        return $credit;
    }
}
