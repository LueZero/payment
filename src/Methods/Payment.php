<?php

namespace Zero\Payment\Methods;

use Exception;

abstract class Payment
{
    /**
     * 必要參數
     */
    protected array $necessaryParameters;

    /**
     * 訂單編號
     */
    protected $orderId;

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
    abstract public function refund($orderId=null);

    /**
     * 搜尋
     */
    abstract public function search();

    /**
     * 請求參數
     */
    abstract public function requestParameter($data): Payment;

    /**
     * 確認
     */
    abstract public function confirm($data);
}
