<?php

namespace Zero\Request\Parameters\LinePay;

class Search
{
    /**
     * array int transactionId
     */
    public $transactionId;

    /**
     * array string orderId
     */
    public $orderId;

    /**
     * array string fields
     */
    public $fields;

    /**
     * 搜尋資料
     */
    public static function createSearch()
    {
        return new Search();
    }
}
