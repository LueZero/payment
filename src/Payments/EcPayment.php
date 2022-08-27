<?php

namespace Zero\Payments;

use Zero\Http;
use Zero\Helpers\DataCheck;

class EcPayment extends Payment
{
    /**
     * @var string merchant id 特店編號
     */
    protected $merchantID;

    /**
     * @var string hash Key
     */
    protected $hashKey;

    /**
     * @var string hash Iv
     */
    protected $hashIv;

    /**
     * 建構子
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    /**
     * 設定配置
     */
    public function setConfigs($configs)
    {
        $this->configs = $configs;
        $this->merchantID = empty($this->configs['paymentParameters']['MerchantID']) == true ? null : $this->configs['paymentParameters']['MerchantID'];
        $this->hashKey = empty($this->configs['paymentParameters']['HashKey']) == true ? null : $this->configs['paymentParameters']['HashKey'];
        $this->hashIv = empty($this->configs['paymentParameters']['HashIV']) == true ? null : $this->configs['paymentParameters']['HashIV'];
    }

    /**
     * 資料處理
     * @override 
     * @return Payment
     */
    public function dataProcess()
    {
        $CheckMacValue = $this->encryption($this->sendData);
        $this->sendData['CheckMacValue'] = $CheckMacValue;
        return $this;
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        DataCheck::checkOrderNumber($this->sendData['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->form(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['checkout'],
            $this->sendData
        );
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        DataCheck::checkOrderNumber($this->sendData['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['search'],
            http_build_query($this->sendData)
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
            http_build_query($this->sendData)
        );
    }

    /**
     * 退款
     */
    public function refund($merchantTradeNo = null)
    {
        DataCheck::checkOrderNumber($this->sendData['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['refund'],
            http_build_query($this->sendData)
        );
    }

    /**
     * 加密
     */
    public function encryption($data)
    {
        return $this->generate($data, $this->hashKey, $this->hashIv);
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
