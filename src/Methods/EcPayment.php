<?php

namespace Zero\Payment\Methods;

use Zero\Payment\Http;
use Zero\Payment\Helpers\DataCheck;
use Zero\Payment\Parameters\EcPaymentRequestParameter;

class EcPayment extends Payment
{
    private EcPaymentRequestParameter $paymentRequestParameter;

    /**
     * 建構子
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
        $this->paymentRequestParameter = new EcPaymentRequestParameter();
    }

    /**
     * 取得請求參數
     */
    public function getRequestParameter()
    {
        return $this->paymentRequestParameter;
    }

    /**
     * 設定請求參數
     */
    public function setRequestParameter($requests): Payment
    {
        DataCheck::whetherEmpty($requests, 'Zero\Payment\Helpers\DataCheck::[requests data is empty]');

        foreach ($requests as $key => $item) {
            if (!isset($this->paymentRequestParameter->$key))
                $this->paymentRequestParameter->$key = $item;
        }
        
        return $this;
    }

    /**
     * 資料處理
     */
    public function dataProcess(): Payment
    {
        $this->sends = (array) $this->paymentRequestParameter;
        $CheckMacValue = $this->encrypt($this->sends);
        $this->sends['CheckMacValue'] = $CheckMacValue;
        return $this;
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        DataCheck::exhaustiveCheckSends($this->necessaryParameters, $this->sends, 'requestParameters');
        return $this->http->form(
            $this->necessaryParameters['paymentUrls']['ecApiUrl'] . $this->necessaryParameters['paymentUrls']['checkoutUrl'],
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
            $this->necessaryParameters['paymentUrls']['ecApiUrl'] . $this->necessaryParameters['paymentUrls']['searchUrl'],
            http_build_query($this->sends)
        );
    }

    /**
     * 搜尋單筆明細資料記錄
     */
    public function searchDetails()
    {
        DataCheck::checkOrderNumber($this->sends['MerchantTradeNo'], 'MerchantTradeNo');
        return $this->http->setup([
            'Content-Type: application/x-www-form-urlencoded'
        ])->post(
            $this->necessaryParameters['paymentUrls']['ecApiUrl'] . $this->necessaryParameters['paymentUrls']['searchDetailsUrl'],
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
            $this->necessaryParameters['paymentUrls']['ecApiUrl'] . $this->necessaryParameters['paymentUrls']['refundUrl'],
            http_build_query($this->sends)
        );
    }

    /**
     * 加密
     */
    public function encrypt($data)
    {
        return $this->generate($data, $this->necessaryParameters['paymentParameters']['HashKey'], $this->necessaryParameters['paymentParameters']['HashIV']);
    }

    /**
     * 綠界加密
     */
    public function generate($arParameters = array(), $HashKey = '', $HashIV = '', $encType = 0)
    {
        $sMacValue = '';
        if (isset($arParameters)) {
            unset($arParameters['CheckMacValue']);
            uksort($arParameters, array('Zero\Payment\Methods\EcPayment', 'merchantSort'));
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
