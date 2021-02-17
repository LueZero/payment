<?php

namespace Zero\Pay\PayMethod;

use Zero\Pay\PayMethod\PayParameterConfig;
use Zero\Pay\PayMethod\PayInterface;
use Zero\Pay\PaySend\SendInterface;
use Zero\Pay\Helper\DataCheck;

class LinePay extends PayParameterConfig implements PayInterface
{
    /**
     * 建構子
     */
    public function __construct($pay, SendInterface $paySend)
    {
        $this->sendMethod = $paySend;
        $this->selectNecessaryParametersConfig($pay);
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        $body = $this->necessaryParameters["ChannelSecret"] . $this->necessaryParameters["checkoutUrl"] . json_encode($this->sendData) . time();
        return $this->sendMethod->checkoutsSend($this->necessaryParameters["lineApiUrl"] . $this->necessaryParameters["checkoutUrl"], json_encode($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->necessaryParameters["ChannelSecret"], true)),
        ]);
    }

    /**
     * 確認
     */
    public function confirm($orderId=null)
    {
        $explodeUrl = explode("{}", $this->necessaryParameters["confirmUrl"]);
        $confirmUrl = $explodeUrl[0] . $orderId . $explodeUrl[1];
        $body = $this->necessaryParameters["ChannelSecret"] . $confirmUrl . json_encode($this->sendData) . time();
        return $this->sendMethod->confirmSend($this->necessaryParameters["lineApiUrl"] . $confirmUrl, json_encode($this->sendData), [
            "Content-Type: application/json; charset=UTF-8",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->necessaryParameters["ChannelSecret"], true)),
        ]);
    }

    public function search()
    {
        $body = $this->necessaryParameters["ChannelSecret"] . $this->necessaryParameters["searchUrl"] . http_build_query($this->sendData) . time();
        return $this->sendMethod->searchSend($this->necessaryParameters["lineApiUrl"] . $this->necessaryParameters["searchUrl"] . "?", http_build_query($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->necessaryParameters["ChannelSecret"], true)),
        ]);
    }

    public function refund($orderId=null)
    {
        $explodeUrl = explode("{}", $this->necessaryParameters["refundUrl"]);
        $refundUrl = $explodeUrl[0] . $orderId . $explodeUrl[1];
        $body = $this->necessaryParameters["ChannelSecret"] . $refundUrl. json_encode($this->sendData) . time();
        return $this->sendMethod->refundSend($this->necessaryParameters["lineApiUrl"] . $refundUrl . "?", json_encode($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->necessaryParameters["ChannelSecret"], true)),
        ]);
    }

    /**
     * 資料處理
     */
    public function dataProcess()
    {
        DataCheck::whetherEmpty($this->sendData, "send data is empty");
    }
}
