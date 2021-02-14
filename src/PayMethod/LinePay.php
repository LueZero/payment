<?php

namespace Zero\Pay\PayMethod;

use Zero\Pay\PayMethod\PayParameter;
use Zero\Pay\PayMethod\PayInterface;
use Zero\Pay\Helper\DataCheck;
use Zero\Pay\PaySend\PaySend;

class LinePay extends PayParameter implements PayInterface
{

    public function __construct($pay)
    {
        $this->sendMenthod = PaySend::setUp($pay);
        $this->selectNecessaryParametersConfig($pay);
    }


    /**
     * 結帳
     */
    public function checkouts()
    {
        $body = $this->necessaryParameters["ChannelSecret"] . $this->necessaryParameters["checkoutUrl"] . json_encode($this->sendData) . time();
        return $this->sendMenthod->checkoutsSend($this->necessaryParameters["lineApiUrl"] . $this->necessaryParameters["checkoutUrl"], json_encode($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->necessaryParameters["ChannelSecret"], true)),
        ]);
    }

    /**
     * 確認
     */
    public function confirm($confirmData)
    {
        $confirmUrl = $this->sendData["confirmUrl"];
        unset($this->sendData["confirmUrl"]);
        $body = $this->necessaryParameters["ChannelSecret"] . $confirmUrl . json_encode($this->sendData) . time();
        return $this->sendMenthod->confirmSend($this->necessaryParameters["lineApiUrl"] . $confirmUrl, json_encode($this->sendData), [
            "Content-Type: application/json; charset=UTF-8",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->necessaryParameters["ChannelSecret"], true)),
        ]);
    }

    public function search()
    {
        $body = $this->necessaryParameters["ChannelSecret"] . $this->necessaryParameters["searchUrl"] . http_build_query($this->sendData) . time();
        return $this->sendMenthod->searchSend($this->necessaryParameters["lineApiUrl"] . $this->necessaryParameters["searchUrl"] . "?", http_build_query($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . base64_encode(hash_hmac('sha256', $body, $this->necessaryParameters["ChannelSecret"], true)),
        ]);
    }

    public function refund()
    {

        
    }

    /**
     * 資料處理
     */
    public function dataProcess()
    {
        DataCheck::whetherEmpty($this->sendData, "send data not defined");
    }
}
