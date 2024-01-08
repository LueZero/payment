<?php

namespace Zero\Payments;

use Zero\Http;
use Zero\Helpers\DataChecker;

class EcPayment extends Payment
{
    /**
     * @var string 
     * 特店編號
     */
    public $merchantID;

    /**
     * @var string
     */
    public $hashKey;

    /**
     * @var string
     */
    public $hashIv;

    /**
     * @var string
     */
    public $creditCheckCode;

    /**
     * 建構子
     * @param Http http
     */
    public function __construct(Http $http)
    {
        parent::__construct();
        $this->http = $http;
        $this->requireConfig('ec');
    }

    /**
     * @param array configs
     */
    public function setConfig($configs)
    {
        $this->configs = $configs;
        $this->merchantID = empty($this->configs['paymentParameters']['MerchantID']) == true ? null : $this->configs['paymentParameters']['MerchantID'];
        $this->hashKey = empty($this->configs['paymentParameters']['HashKey']) == true ? null : $this->configs['paymentParameters']['HashKey'];
        $this->hashIv = empty($this->configs['paymentParameters']['HashIV']) == true ? null : $this->configs['paymentParameters']['HashIV'];
        $this->creditCheckCode = empty($this->configs['paymentParameters']['CreditCheckCode']) == true ? null : $this->configs['paymentParameters']['CreditCheckCode'];
    }

    /**
     * 資料處理
     * @override 
     * @return Payment
     */
    public function processData()
    {
        $CheckMacValue = $this->encrypt($this->sendData);
        $this->sendData['CheckMacValue'] = $CheckMacValue;
        return $this;
    }

    /**
     * 結帳
     * @return string 
     */
    public function checkout()
    {
        DataChecker::checkOrderNumber($this->sendData['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->form(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['checkout'],
            $this->sendData
        );
    }

    /**
     * 搜尋資料
     * @return string 
     */
    public function search()
    {
        DataChecker::checkOrderNumber($this->sendData['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['search'],
            http_build_query($this->sendData)
        );
    }

    /**
     * 搜尋單筆明細資料記錄
     * @return string 
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
     * @param string merchantTradeNo
     */
    public function refund($merchantTradeNo = null)
    {
        DataChecker::checkOrderNumber($this->sendData['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['refund'],
            http_build_query($this->sendData)
        );
    }

    /**
     * 加密
     * @param array data
     * @return string
     */
    public function encrypt($data)
    {
        return $this->generate($data, $this->hashKey, $this->hashIv);
    }

    /**
     * 綠界加密
     * @param array arParameters
     * @param string HashKey
     * @param string HashIV
     * @param int encType
     * @return string
     */
    public function generate($arParameters = array(), $HashKey = '', $HashIV = '', $encType = 0)
    {
        $sMacValue = '';
        if (isset($arParameters)) {
            unset($arParameters['CheckMacValue']);
            uksort($arParameters, array('Zero\Payments\EcPayment', 'sortMerchant'));
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
     * @param string string1
     * @param string string2
     */
    private static function sortMerchant($string1, $string2)
    {
        return strcasecmp($string1, $string2);
    }
}
