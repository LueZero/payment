<?php

namespace Zero\Payments;

use Zero\Http;
use Zero\Helpers\DataCheck;

class LinePayment extends Payment
{
    /**
     * 建構子
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    /**
     * 加密
     */
    public function encrypt($data)
    {
        return base64_encode(hash_hmac('sha256', $data, $this->configs['paymentParameters']['ChannelSecret'], true));
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $this->configs['paymentURLs']['checkout'] . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['checkout'],
            json_encode($this->sendDatas)
        );
    }

    /**
     * 確認
     */
    public function confirm($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['confirm']);
        $confirm = $explode[0] . $transactionId . $explode[1];
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $confirm . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $confirm,
            json_encode($this->sendDatas)
        );
    }

    /**
     * 捕獲
     */
    public function capture($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['capture']);
        $capture = $explode[0] . $transactionId . $explode[1];
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $capture . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $capture,
            json_encode($this->sendDatas)
        );
    }

    /**
     * 無效處理
     */
    public function void($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['void']);
        $confirm = $explode[0] . $transactionId . $explode[1];
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $confirm . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $confirm,
            json_encode($this->sendDatas)
        );
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        DataCheck::checkOrderNumber($this->sendDatas['orderId'], 'orderId');
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $this->configs['paymentURLs']['search'] . http_build_query($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->get(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['search'],
            $this->sendDatas
        );
    }

    /**
     * 退款
     */
    public function refund($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['refund']);
        $refund = $explode[0] . $transactionId . $explode[1];
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $refund . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $refund,
            json_encode($this->sendDatas)
        );
    }
}
