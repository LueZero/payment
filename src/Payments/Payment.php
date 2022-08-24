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
     * array send datas
     */
    protected $sendDatas;

    /**
     * array request parameter 
     */
    protected $requestParameter;

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
     * 取得 class requests 取得請求參數
     */
    public function getRequestParameter()
    {
        return $this->requestParameter;
    }

    /**
     * return class Payment 設定請求參數
     */
    abstract function setRequestParameters($requestParameters);

    /**
     * return class Payment 資料處理
     */
    public function dataProcess()
    {
        $this->sendDatas = (array) $this->requestParameter;

        foreach( $this->sendDatas as $key=>$item)
            if (empty($item))
                unset($this->sendDatas[$key]);
                
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
