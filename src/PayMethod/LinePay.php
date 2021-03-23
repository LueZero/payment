<?php

namespace Zero\Pay\PayMethod;

use Zero\Pay\PayMethod\PayParameter;
use Zero\Pay\PayMethod\PayInterface;
use Zero\Pay\PaySend\SendInterface;
use Zero\Pay\Helper\DataCheck;

class LinePay extends PayParameter implements PayInterface
{
    /**
     * 建構子
     */
    public function __construct($pay, SendInterface $paySend)
    {
        parent::__construct();
        $this->necessaryParameters = $this->necessaryParameters[$pay];
        $this->sendMethod = $paySend;
    }

    /**
     * 請求參數
     */
    public function requestParameter($data)
    {
        $this->sendData = $data;
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        DataCheck::checkOrderNumber($this->sendData["orderId"], "orderId");
        DataCheck::checkTotalAmount($this->sendData["amount"]);
        DataCheck::exhaustiveCheckSendData($this->necessaryParameters, $this->sendData, "checkoutParameter");
        $body = $this->necessaryParameters["ChannelSecret"] . $this->necessaryParameters["checkoutUrl"] . json_encode($this->sendData) . time();
        return $this->sendMethod->checkoutsSend($this->necessaryParameters["lineApiUrl"] . $this->necessaryParameters["checkoutUrl"], json_encode($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . $this->encrypt($body),
        ]);
    }

    /**
     * 確認
     */
    public function confirm($orderId=null)
    {
        DataCheck::checkOrderNumber($orderId, "orderId");
        $explodeUrl = explode("{}", $this->necessaryParameters["confirmUrl"]);
        $confirmUrl = $explodeUrl[0] . $orderId . $explodeUrl[1];
        $body = $this->necessaryParameters["ChannelSecret"] . $confirmUrl . json_encode($this->sendData) . time();
        return $this->sendMethod->confirmSend($this->necessaryParameters["lineApiUrl"] . $confirmUrl, json_encode($this->sendData), [
            "Content-Type: application/json; charset=UTF-8",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . $this->encrypt($body),
        ]);
    }


    /**
     * 搜尋資料
     */
    public function search()
    {
        DataCheck::checkOrderNumber($this->sendData["orderId"], "orderId");
        $body = $this->necessaryParameters["ChannelSecret"] . $this->necessaryParameters["searchUrl"] . http_build_query($this->sendData) . time();
        return $this->sendMethod->searchSend($this->necessaryParameters["lineApiUrl"] . $this->necessaryParameters["searchUrl"] . "?", http_build_query($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . $this->encrypt($body),
        ]);
    }

    /**
     * 退款
     */
    public function refund($orderId=null)
    {
        DataCheck::checkOrderNumber($orderId, "orderId");
        $explodeUrl = explode("{}", $this->necessaryParameters["refundUrl"]);
        $refundUrl = $explodeUrl[0] . $orderId . $explodeUrl[1];
        $body = $this->necessaryParameters["ChannelSecret"] . $refundUrl. json_encode($this->sendData) . time();
        return $this->sendMethod->refundSend($this->necessaryParameters["lineApiUrl"] . $refundUrl . "?", json_encode($this->sendData), [
            "Content-Type: application/json",
            "X-LINE-ChannelId: " . $this->necessaryParameters["ChannelId"],
            "X-LINE-Authorization-Nonce: " . time(),
            "X-LINE-Authorization: " . $this->encrypt($body),
        ]);
    }

    /**
     * 加密
     */
    public function encrypt($data)
    {
        return base64_encode(hash_hmac('sha256', $data, $this->necessaryParameters["ChannelSecret"], true));
    }

    /**
     * 資料處理
     */
    public function dataProcess()
    {
        DataCheck::whetherEmpty($this->sendData, "send data is empty");
    }
}
