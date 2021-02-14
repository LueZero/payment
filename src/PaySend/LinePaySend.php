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

    public function checkoutsSend($sendUrl, $sendData, $headers=[])
    {
        return $this->post($sendUrl, $sendData, $headers);
    }

    public function searchSend($sendUrl, $sendData, $headers = [])
    {
        return $this->get($sendUrl, $sendData, $headers);
    }

    public function confirmSend($sendUrl, $sendData, $headers = [])
    {
        return $this->post($sendUrl, $sendData, $headers);
    }

    public function refundSend()
    {
      
    }
}
