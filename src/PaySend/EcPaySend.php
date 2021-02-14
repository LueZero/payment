<?php

namespace Zero\Pay\PaySend;

use Zero\Pay\PaySend\Send;

class EcPaySend extends Send
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkoutsSend($sendUrl, $sendData, $headers = [])
    {   
        return $this->form($sendUrl, $sendData, $headers);
    }

    public function searchSend($sendUrl, $sendData, $headers = [])
    {
        return $this->post($sendUrl, $sendData, $headers);
    }

    public function refundSend()
    {
        
    }
}