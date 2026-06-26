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
        $configPath = dirname(__DIR__) . '/config.php';

        if (!file_exists($configPath)) {
            throw new \Exception('Zero\Payment\Payment::[Payment config file not found. Copy src/config.example.php to src/config.php]');
        }

        $configs = require($configPath);

        if (empty($configs[$paymentName]))
            throw new \Exception('Zero\Payment\Payment::[Payment config is empty]');

        $this->setConfig($configs[$paymentName]);
    }

    /**
     * 設定配置檔案
     * @param array configs
     */
    public function setConfig($configs)
    {
        $this->configs = $configs;
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
    public function setRequestParameter($requestParameters)
    {
        DataChecker::whetherEmpty($requestParameters, 'Zero\Payment\Helpers\DataChecker::[request parameters is empty]');

        $this->sendData = $requestParameters;

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
