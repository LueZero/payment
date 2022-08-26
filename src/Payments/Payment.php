<?php

namespace Zero\Payments;

use Exception;
use Zero\Helpers\DataCheck;
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
     * @return string 
     */
    abstract public function encryption($data);

    /**
     * 取得發送參數
     * @return array
     */
    public function getSendData()
    {
        return $this->sendData;
    }

    /**
     * 設定請求參數
     * @return Payment 
     */
    public function setRequestParameters($requestParameters)
    {
        DataCheck::whetherEmpty($requestParameters, 'Zero\Payment\Helpers\DataCheck::[request parameters is empty]');

        foreach ($requestParameters as $key => $requestParameter)
            $this->sendData[$key] = $requestParameter;

        return $this->dataProcess();
    }

    /**
     * 資料處理
     * @return Payment 
     */
    public function dataProcess()
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
    abstract public function refund($data);
}
