<?php

namespace Zero\Payments;

use Zero\Helpers\DataChecker;
use Zero\Http;

abstract class Payment
{
    /**     
     * @var Http 
     * 請求功能
     */
    protected $http;

    /**     
     * @var array
     * 配置
     */
    protected $configs;

    /**
     * @var array
     * 發送資料
     */
    protected $sendData;

    public function __construct()
    {
    }

    /**
     * 呼叫配置檔案
     * @param string paymentName
     * @throws \Exception
     */
    public function requireConfig($paymentName)
    {
        $configs = require(dirname(__DIR__).'/config.php');

        if (empty($configs[$paymentName]))
            throw new \Exception('Zero\Payment\Payment::[payment config is empty]');

        $this->setConfigs($configs[$paymentName]);
    }

    /**
     * 設定配置檔案
     * @param array configs
     */
    function setConfigs($configs) 
    {
        $this->$configs = $configs;
    }

    /**
     * 設定配置
     * @return array
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * 加密
     * @param string data
     * @return string
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
     * @param array requestParameters
     * @return Payment 
     */
    public function setRequestParameters($requestParameters)
    {
        DataChecker::whetherEmpty($requestParameters, 'Zero\Payment\Helpers\DataChecker::[request parameters is empty]');

        foreach ($requestParameters as $key => $requestParameter) {
            $this->sendData[$key] = $requestParameter;
        }

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
    abstract public function checkout();

    /**
     * 搜尋
     * @return string 
     */
    abstract public function search();

    /**
     * 退款
     * @return mixed data 
     * @return string 
     */
    abstract public function refund($data = null);
}
