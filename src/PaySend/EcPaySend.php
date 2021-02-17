<?php

namespace Zero\Pay\PaySend;

use Zero\Pay\PaySend\Send;
use Zero\Pay\PaySend\SendInterface;

class EcPaySend implements SendInterface
{
    public function checkoutsSend($sendUrl, $sendData, $headers = [])
    {
        return Send::setUp()->form($sendUrl, $sendData, $headers);
    }

    public function searchSend($sendUrl, $sendData, $headers = [])
    {
        return Send::setUp()->post($sendUrl, $sendData, $headers);
    }

    public function refundSend($sendUrl, $sendData, $headers = [])
    {
        return Send::setUp()->post($sendUrl, $sendData, $headers);
    }
}
