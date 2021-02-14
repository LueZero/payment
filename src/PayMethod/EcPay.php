<?php

namespace Zero\Pay\PayMethod;

use Zero\Pay\PayMethod\PayParameter;
use Zero\Pay\PayMethod\PayInterface;
use Zero\Pay\Helper\DataCheck;
use Zero\Pay\PaySend\PaySend;

class EcPay extends PayParameter implements PayInterface
{
    public function __construct($pay)
    {
        $this->sendMenthod = PaySend::setUp($pay);
        $this->selectNecessaryParametersConfig($pay);
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        return $this->sendMenthod->checkoutsSend($this->necessaryParameters["checkoutUrl"], $this->sendData, array("Content-type: application/x-www-form-urlencoded"));
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        return $this->sendMenthod->searchSend($this->necessaryParameters["searchUrl"], http_build_query($this->sendData), array("Content-Type: application/x-www-form-urlencoded"));
    }

    /**
     * 退款
     */
    public function refund()
    {
    }

    /**
     * 資料處理
     */
    public function dataProcess()
    {
        DataCheck::whetherEmpty($this->sendData, "send data not defined");
        $CheckMacValue = $this->generate($this->sendData, $this->necessaryParameters["HashKey"], $this->necessaryParameters["HashIV"]);
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
