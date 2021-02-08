<?php

namespace Zero\Pay\PayMethod;

use Zero\Pay\PayMethod\Parameter;
use Zero\Pay\PayMethod\PayInterface;
use Zero\Pay\Helper\DataCheck;
use Zero\Pay\PaySend\PaySend;

class EcPay extends Parameter implements PayInterface
{
    public $MerchantID;
    public $HashKey;
    public $HashIV;

    public function __construct($sendPay)
    {
        $this->send = PaySend::setUp($sendPay);
    }

    public function setPar($searchData)
    {
        return $this->sendData = $searchData;
    }

    public function createOrder($orderData)
    {
        return $this->sendData = $orderData;
    }

    public function checkOut()
    {
        return $this->send->payMoney($this->checkoutUrl, $this->sendData, array("Content-type: application/x-www-form-urlencoded"));
    }

    public function searchOrder()
    {
        return $this->send->search($this->searchUrl, http_build_query($this->sendData), array("Content-Type: application/x-www-form-urlencoded"));
    }

    public function refund()
    {
    }

    public function dataProcess()
    {
        DataCheck::whetherEmpty($this->sendData, "send data not defined");
        $CheckMacValue = $this->generate($this->sendData,$this->HashKey, $this->HashIV);
        $this->sendData["CheckMacValue"] = $CheckMacValue;
    }

    public function generate($arParameters = array(), $HashKey = '', $HashIV = '', $encType = 0)
    {
        $sMacValue = '';
        if (isset($arParameters)) {
            unset($arParameters['CheckMacValue']);
            uksort($arParameters, array('Zero\Pay\PayMethod\EcPay', 'merchantSort'));
            $sMacValue = 'HashKey=' . $HashKey;
            foreach ($arParameters as $key => $value) {
                $sMacValue .= '&' . $key . '=' . $value;
            }
            $sMacValue .= '&HashIV=' . $HashIV;
            $sMacValue = urlencode($sMacValue);
            $sMacValue = strtolower($sMacValue);
            $sMacValue = str_replace('%2d', '-', $sMacValue);
            $sMacValue = str_replace('%5f', '_', $sMacValue);
            $sMacValue = str_replace('%2e', '.', $sMacValue);
            $sMacValue = str_replace('%21', '!', $sMacValue);
            $sMacValue = str_replace('%2a', '*', $sMacValue);
            $sMacValue = str_replace('%28', '(', $sMacValue);
            $sMacValue = str_replace('%29', ')', $sMacValue);
            $sMacValue = hash('sha256', $sMacValue);
            $sMacValue = strtoupper($sMacValue);
        }
        return $sMacValue;
    }

    private static function merchantSort($a, $b)
    {
        return strcasecmp($a, $b);
    }
}
