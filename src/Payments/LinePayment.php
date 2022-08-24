<?php

namespace Zero\Payments;

use Zero\Http;
use Zero\Helpers\DataCheck;
use Zero\Bodies\LineBody;

class LinePayment extends Payment
{
    /**
     * 建構子
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
        $this->body = new LineBody();
    }

    /**
     * return class Payment 設定body
     */
    public function setBody($requests)
    {
        DataCheck::whetherEmpty($requests, 'Zero\Payment\Helpers\DataCheck::[requests data is empty]');
        foreach ($requests as $key => $item) {
            if (!isset($this->body->$key))
                $this->body->$key = $item;
        }

        return $this->dataProcess();
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
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $this->configs['paymentUrls']['checkoutUrl'] . json_encode($this->sends) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentUrls']['lineApiUrl'] . $this->configs['paymentUrls']['checkoutUrl'],
            json_encode($this->sends)
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
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $confirmUrl . json_encode($this->sends) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentUrls']['lineApiUrl'] . $confirmUrl,
            json_encode($this->sends)
        );
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        DataCheck::checkOrderNumber($this->sends['orderId'], 'orderId');
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $this->configs['paymentUrls']['searchUrl'] . http_build_query($this->sends) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->get(
            $this->configs['paymentUrls']['lineApiUrl'] . $this->configs['paymentUrls']['searchUrl'],
            $this->sends
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
        $body = $this->configs['paymentParameters']['ChannelSecret'] . $refundUrl . json_encode($this->sends) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->configs['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentUrls']['lineApiUrl'] . $refundUrl,
            json_encode($this->sends)
        );
    }
}
