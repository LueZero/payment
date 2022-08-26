<?php

namespace Zero\Payments;

use Zero\Http;
use Zero\Helpers\DataCheck;

class EcPayment extends Payment
{
    /**
     * 建構子
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    /**
     * 資料處理
     * @override 
     * @return Payment
     */
    public function dataProcess()
    {
        $CheckMacValue = $this->encrypt($this->sendDatas);
        $this->sendDatas['CheckMacValue'] = $CheckMacValue;
        return $this;
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        DataCheck::checkOrderNumber($this->sendDatas['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->form(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['checkout'],
            $this->sendDatas
        );
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        DataCheck::checkOrderNumber($this->sendDatas['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['search'],
            http_build_query($this->sendDatas)
        );
    }

    /**
     * 搜尋單筆明細資料記錄
     */
    public function searchDetail()
    {
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['searchDetail'],
            http_build_query($this->sendDatas)
        );
    }

    /**
     * 退款
     */
    public function refund($merchantId = null)
    {
        DataCheck::checkOrderNumber($this->sendDatas['MerchantTradeNo'], 'MerchantTradeNo');


        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['refund'],
            http_build_query($this->sendDatas)
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
