<?php

namespace Zero\Payments;

use Exception;
use Zero\Payment\Helpers\DataCheck;
use Zero\Payment\Http;

abstract class Payment
{
    /**
     * class Http 請求功能
     */
    protected $http;

    /**
     * array configs 配置
     */
    protected $configs;

    /**
     * array sends 送參數
     */
    protected $sends;

    /**
     * class PaymentRequestParameter
     */
    protected $paymentRequestParameter;

    /**
     * void 設定配置參數
     */
    public function setConfigs($configs)
    {
        $this->configs = $configs;
    }

    /**
     * return string 加密
     */
    abstract public function encrypt($data);

    /**
     * return array 取得請求參數
     */
    abstract public function getRequestParameter();

    /**
     * return class Payment 設定請求參數
     */
    abstract function setRequestParameter($requests);

    /**
     * return class Payment 資料處理
     */
    public function dataProcess()
    {
        $this->sends = (array) $this->paymentRequestParameter;
        return $this;
    }

    /**
     * return string 結帳
     */
    abstract public function checkouts();

    /**
     * return string 退款
     */
    abstract public function refund($data);

    /**
     * return string 搜尋
     */
    abstract public function search();

    /**
     * return string 確認
     */
    abstract public function confirm($data);
}
