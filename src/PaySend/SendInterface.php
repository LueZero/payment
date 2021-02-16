<?php

namespace Zero\Pay\PaySend;

interface SendInterface
{
    public function checkoutsSend($sendUrl, $sendData, $headers);
    public function searchSend($sendUrl, $sendData, $headers);
    public function refundSend();
}
