<?php

namespace Zero\Payments;

use Zero\Http;
use Zero\Helpers\DataCheck;
use Zero\Bodies\EcBody;

class EcPayment extends Payment
{
    /**
     * 建構子
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
        $this->body = new Ecbody();
    }

    /**
     * return class Payment 設定body
     */
    public function setBody($requests)
    {
        DataCheck::whetherEmpty($requests, 'Zero\Payment\Helpers\DataCheck::[requests data is empty]');
        foreach ($requests as $key => $item) {
            if (!isset($this->body->$key))
                $this->body->$key = $item;
        }

        return $this->dataProcess();
    }

    /**
     * @override 
     * return class Payment 資料處理
     */
    public function dataProcess()
    {
        $this->sends = (array) $this->body;
        foreach($this->sends as $key=>$item)
            if (empty($item))
                unset($this->sends[$key]);

        $CheckMacValue = $this->encrypt($this->sends);
        $this->sends['CheckMacValue'] = $CheckMacValue;
        return $this;
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        return $this->http->form(
            $this->configs['paymentUrls']['ecApiUrl'] . $this->configs['paymentUrls']['checkoutUrl'],
            $this->sends
        );
    }

    /**
     * 確認
     */
    public function confirm($merchantId = null)
    {
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        DataCheck::checkOrderNumber($this->sends['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentUrls']['ecApiUrl'] . $this->configs['paymentUrls']['searchUrl'],
            http_build_query($this->sends)
        );
    }

    /**
     * 搜尋單筆明細資料記錄
     */
    public function searchDetails()
    {
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentUrls']['ecApiUrl'] . $this->configs['paymentUrls']['searchDetailsUrl'],
            http_build_query($this->sends)
        );
    }

    /**
     * 退款
     */
    public function refund($merchantId = null)
    {
        DataCheck::checkOrderNumber($this->sends['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentUrls']['ecApiUrl'] . $this->configs['paymentUrls']['refundUrl'],
            http_build_query($this->sends)
        );
    }

    /**
     * 加密
     */
    public function encrypt($data)
    {
        return $this->generate($data, $this->configs['paymentParameters']['HashKey'], $this->configs['paymentParameters']['HashIV']);
    }

    /**
     * 綠界加密
     */
    public function generate($arParameters = array(), $HashKey = '', $HashIV = '', $encType = 0)
    {
        $sMacValue = '';
        if (isset($arParameters)) {
            unset($arParameters['CheckMacValue']);
            uksort($arParameters, array('Zero\Payments\EcPayment', 'merchantSort'));
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
