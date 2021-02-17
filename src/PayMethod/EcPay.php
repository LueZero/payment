<?php

namespace Zero\Pay\PayMethod;

use Zero\Pay\PayMethod\PayParameterConfig;
use Zero\Pay\PayMethod\PayInterface;
use Zero\Pay\PaySend\SendInterface;
use Zero\Pay\Helper\DataCheck;

class EcPay extends PayParameterConfig implements PayInterface
{
    /**
     * 建構子
     */
    public function __construct($pay, SendInterface $paySend)
    {
        $this->sendMethod = $paySend;
        $this->selectNecessaryParametersConfig($pay);
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        return $this->sendMethod->checkoutsSend($this->necessaryParameters["ecPayApiUrl"].$this->necessaryParameters["checkoutUrl"], $this->sendData, array("Content-type: application/x-www-form-urlencoded"));
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        return $this->sendMethod->searchSend($this->necessaryParameters["ecPayApiUrl"].$this->necessaryParameters["searchUrl"], http_build_query($this->sendData), array("Content-Type: application/x-www-form-urlencoded"));
    }

    /**
     * 搜尋單筆明細資料記錄
     */
    public function searchDetails()
    {
        return $this->sendMethod->searchSend($this->necessaryParameters["ecPayApiUrl"].$this->necessaryParameters["searchDetailsUrl"], http_build_query($this->sendData), array("Content-Type: application/x-www-form-urlencoded"));
    }

    /**
     * 退款
     */
    public function refund($orderId=null)
    {
        return $this->sendMethod->searchSend($this->necessaryParameters["ecPayApiUrl"] . $this->necessaryParameters["refundUrl"], http_build_query($this->sendData), array("Content-Type: application/x-www-form-urlencoded"));
    }

    /**
     * 資料處理
     */
    public function dataProcess()
    {
        DataCheck::whetherEmpty($this->sendData, "send data is empty");
        $CheckMacValue = $this->generate($this->sendData, $this->necessaryParameters["HashKey"], $this->necessaryParameters["HashIV"]);
        $this->sendData["CheckMacValue"] = $CheckMacValue;
    }

    /**
     * 綠界加密
     */
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

    /**
     * 綠界加密排序
     */
    private static function merchantSort($a, $b)
    {
        return strcasecmp($a, $b);
    }
}
