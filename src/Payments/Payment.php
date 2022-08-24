<?php

namespace Zero\Payments;

use Exception;
use Zero\Helpers\DataCheck;
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
     * return array
     */
    public function getSendDatas()
    {
        return $this->sendDatas;
    }

    /**
     * return class Payment 設定請求參數
     */
    public function setRequestParameters($requestParameters)
    {
        DataCheck::whetherEmpty($requestParameters, 'Zero\Payment\Helpers\DataCheck::[request parameters data is empty]');

        foreach ($requestParameters as $key => $requestParameter)
            $this->sendDatas[$key] = $requestParameter;

        return $this->dataProcess();
    }

    /**
     * return class Payment 資料處理
     */
    public function dataProcess()
    {
        return $this;
    }

    /**
     * return string 結帳
     */
    abstract public function checkouts();

    /**
     * return string 搜尋
     */
    abstract public function search();

     /**
     * return string 退款
     */
    abstract public function refund($data);
}
