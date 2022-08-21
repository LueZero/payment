<?php

namespace Zero\Payment\Methods;

use Exception;
use Zero\Payment\Helpers\DataCheck;
use Zero\Payment\Http;

abstract class Payment
{
    /**
     * 請求功能參數
     */
    protected Http $http;

    /**
     * 必要參數
     */
    protected array $necessaryParameters;

    /**
     * 發送參數
     */
    protected array $sends;

    /**
     * 設定參數
     */
    public function setParameters($configs)
    {
        $this->necessaryParameters = $configs;
    }

    /**
     * 加密
     */
    abstract public function encrypt($data);

    /**
     * 資料處理
     */
    abstract public function dataProcess(): Payment;

    /**
     * 結帳
     */
    abstract public function checkouts();

    /**
     * 退款
     */
    abstract public function refund($data);

    /**
     * 搜尋
     */
    abstract public function search();

    /**
     * 確認
     */
    abstract public function confirm($data);

    /**
     * 請求參數
     */
    public function requestParameter($data): Payment
    {
        DataCheck::whetherEmpty($data, 'Send data is empty');

        foreach ($data as $key => $item) {
            if (!isset($this->$key))
                $this->$key = $item;
        }

        $this->sends = $this->getPublicVars();
        return $this;
    }

    public function getPublicVars()
    {
        $me = new class
        {
            function getPublicVars($object)
            {
                return get_object_vars($object);
            }
        };
        return $me->getPublicVars($this);
    }
}
