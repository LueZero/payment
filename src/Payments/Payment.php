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
     * class body
     */
    protected $body;

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
     * 取得 class body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * return class Payment set body
     */
    abstract function setbody($requests);

    /**
     * return class Payment 資料處理
     */
    public function dataProcess()
    {
        $this->sends = (array) $this->body;
        foreach($this->sends as $key=>$item)
            if (empty($item))
                unset($this->sends[$key]);
                
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
