<?php

namespace Zero\Pay\PayMethod;

use Exception;

abstract class PayParameter
{
    /**
     * 發送方式
     */
    protected $sendMethod;
    
    /**
     * 必要參數
     */
    protected $necessaryParameters;
    
    /**
     * 訂單編號
     */
    protected $orderId;

    /**
     * 發送參數
     */
    protected $sendData;
}
