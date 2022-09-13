<?php

namespace Zero\Request\Parameters\LinePay;

class Search
{
    /**
     * @var array int
     */
    public $transactionId;

    /**
     * @var array string
     */
    public $orderId;

    /**
     * @var array string
     */
    public $fields;

    /**
     * 搜尋資料
     * @return Search
     */
    public static function createSearch()
    {
        return new Search();
    }
}
