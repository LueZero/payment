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

    public function setPar($searchData)
    {
        return $this->sendData = $searchData;
    }

    public function createOrder($orderData)
    {
        return $this->sendData = $orderData;
    }

    public function checkOut()
    {
        $body = $this->ChannelSecret . '/v3/payments/request' . json_encode($this->sendData) . time();
        return $this->send->setUp()->payMoney($this->checkoutUrl, json_encode($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->ChannelId,
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->ChannelSecret, true)),
        ]);
    }

    public function dataProcess()
    {
        DataCheck::whetherEmpty($this->sendData, "send data not defined");
    }

    public function confirm($confirmData)
    {
        $this->confirmUrl = $this->sendData["completeConfirmUrl"];
        $confirmUrl = $this->sendData["confirmUrl"];
        unset($this->sendData["completeConfirmUrl"]);
        unset($this->sendData["confirmUrl"]);
        $body = $this->ChannelSecret . $confirmUrl . json_encode($this->sendData) . time();
        return $this->send->setUp()->confirm($this->confirmUrl, json_encode($this->sendData), [
            "Content-Type: application/json; charset=UTF-8",
            "X-LINE-ChannelId: " . $this->ChannelId,
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->ChannelSecret, true)),
        ]);
    }

    public function searchOrder()
    {
        $body = $this->ChannelSecret . '/v3/payments' . http_build_query($this->sendData) . time();
        return $this->send->setUp()->search($this->searchUrl . "?", http_build_query($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->ChannelId,
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->ChannelSecret, true)),
        ]);
    }

    public function refund()
    {

    }
}
