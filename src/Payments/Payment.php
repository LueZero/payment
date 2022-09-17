<?php

namespace Zero\Payments;

use Exception;
use Zero\Helpers\DataChecker;
use Zero\Payment\Http;

abstract class Payment
{
    /**
     * 請求功能
     * @var Http 
     */
    protected $http;

    /**
     * 配置
     * @var array
     */
    protected $configs;

    /**
     * @var array
     */
    protected $sendData;

    /**
     * 設定配置
     */
    public function setConfigs($configs)
    {
        $this->configs = $configs;
    }

    /**
     * 加密
     * @param string 
     */
    abstract public function encrypt($data);

    /**
     * 取得發送參數
     * @return array
     */
    public function getSendingData()
    {
        return $this->sendData;
    }

    /**
     * 設定請求參數
     * @return Payment 
     */
    public function setRequestParameters($requestParameters)
    {
        DataChecker::whetherEmpty($requestParameters, 'Zero\Payment\Helpers\DataChecker::[request parameters is empty]');

        foreach ($requestParameters as $key => $requestParameter)
            $this->sendData[$key] = $requestParameter;

        return $this->processData();
    }

    /**
     * 資料處理
     * @return Payment 
     */
    public function processData()
    {
        return $this;
    }

    /**
     * 結帳
     * @return string 
     */
    abstract public function checkouts();

    /**
     * 搜尋
     * @return string 
     */
    abstract public function search();

    /**
     * 退款
     * @return string 
     */
    abstract public function refund($data = null);
}
