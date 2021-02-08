<?php

namespace Zero\Pay\PaySend;

use Zero\Pay\PaySend\Send;

class LinePaySend extends Send
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function setUp()
    {
        return new LinePaySend();
    }

    public function payMoney($sendUrl, $sendData, $headers=[])
    {
        return $this->post($sendUrl, $sendData, $headers);
    }

    public function search($sendUrl, $sendData, $headers = [])
    {
        return $this->get($sendUrl, $sendData, $headers);
    }

    public function confirm($sendUrl, $sendData, $headers = [])
    {
        return $this->post($sendUrl, $sendData, $headers);
    }

    public function refundMoney()
    {
      
    }
}
