<?php

namespace Zero\Pay\PayMethod;

use Zero\Pay\PayMethod\PayInterface;
use Zero\Pay\PayMethod\Parameter;
use Zero\Pay\Helper\DataCheck;
use Zero\Pay\PaySend\PaySend;

class LinePay extends Parameter implements PayInterface
{
    public $ChannelId;
    public $ChannelSecret;

    public function __construct($sendPay)
    {
        $this->send = PaySend::setUp($sendPay);
    }

    public function createOrder($orderData)
    {
        return $this->orderData = $orderData;
    }

    public function checkOut()
    {
        $body = $this->ChannelSecret . '/v3/payments/request' . json_encode($this->orderData) . time();
        return $this->send->setUp()->payMoney($this->url, json_encode($this->orderData), [
            "Content-Type: application/json;",
            "X-LINE-ChannelId: " . $this->ChannelId,
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->ChannelSecret, true)),
        ]);
    }

    public function dataProcess()
    {
        DataCheck::whetherEmpty($this->orderData, "order not defined");
    }

    public function refund()
    {
    }

    public function searchOrder()
    {
    }
}
