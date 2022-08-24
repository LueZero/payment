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
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $this->configs['paymentUrls']['checkoutUrl'] . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentUrls']['lineApiUrl'] . $this->configs['paymentUrls']['checkoutUrl'],
            json_encode($this->sendDatas)
        );
    }

    /**
     * 確認
     */
    public function confirm($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explodeUrl = explode('{}', $this->configs['paymentUrls']['confirmUrl']);
        $confirmUrl = $explodeUrl[0] . $transactionId . $explodeUrl[1];
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $confirmUrl . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentUrls']['lineApiUrl'] . $confirmUrl,
            json_encode($this->sendDatas)
        );
    }

    /**
     * 捕獲
     */
    public function capture($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explodeUrl = explode('{}', $this->configs['paymentUrls']['captureUrl']);
        $confirmUrl = $explodeUrl[0] . $transactionId . $explodeUrl[1];
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $confirmUrl . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentUrls']['lineApiUrl'] . $confirmUrl,
            json_encode($this->sendDatas)
        );
    }

    /**
     * 無效處理
     */
    public function void($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explodeUrl = explode('{}', $this->configs['paymentUrls']['voidUrl']);
        $confirmUrl = $explodeUrl[0] . $transactionId . $explodeUrl[1];
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $confirmUrl . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentUrls']['lineApiUrl'] . $confirmUrl,
            json_encode($this->sendDatas)
        );
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        DataCheck::checkOrderNumber($this->sendDatas['orderId'], 'orderId');
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $this->configs['paymentUrls']['searchUrl'] . http_build_query($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->get(
            $this->configs['paymentUrls']['lineApiUrl'] . $this->configs['paymentUrls']['searchUrl'],
            $this->sendDatas
        );
    }

    /**
     * 退款
     */
    public function refund($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explodeUrl = explode('{}', $this->configs['paymentUrls']['refundUrl']);
        $refundUrl = $explodeUrl[0] . $transactionId . $explodeUrl[1];
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $refundUrl . json_encode($this->sendDatas) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentUrls']['lineApiUrl'] . $refundUrl,
            json_encode($this->sendDatas)
        );
    }
}
