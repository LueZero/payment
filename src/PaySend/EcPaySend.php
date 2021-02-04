<?php

namespace Zero\Pay\PaySend;

use Zero\Pay\PaySend\Send;

class EcPaySend extends Send
{
    public static $sendUrl;
    public static $sendData;

    public function __construct()
    {
        parent::__construct();
    }

    public function payMoney($sendUrl, $sendData, $headers)
    {   
        return $this->form($sendUrl, $sendData, $headers);
    }

    public function refundMoney()
    {
        
    }
}