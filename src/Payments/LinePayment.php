<?php

namespace Zero\Payments;

use Zero\Http;
use Zero\Helpers\DataChecker;

class LinePayment extends Payment
{
    /**
     * @var string channelId
     */
    protected $channelId;

    /**
     * @var string channelSecret
     */
    protected $channelSecret;

    /**
     * 建構子
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
     
    }

    /**
     * 設定配置
     */
    public function setConfigs($configs)
    {
        $this->configs = $configs;
        $this->channelId = empty($this->configs['paymentParameters']['ChannelId']) == true ? null : $this->configs['paymentParameters']['ChannelId'];
        $this->channelSecret = empty($this->configs['paymentParameters']['ChannelSecret']) == true ? null : $this->configs['paymentParameters']['ChannelSecret'];
    }

    /**
     * 加密
     */
    public function encryption($data)
    {
        return base64_encode(hash_hmac('sha256', $data, $this->channelSecret, true));
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        $body = $this->channelSecret . $this->configs['paymentURLs']['checkout'] . json_encode($this->sendingData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encryption($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['checkout'],
            json_encode($this->sendingData)
        );
    }

    /**
     * 確認
     */
    public function confirm($transactionId)
    {
        DataChecker::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['confirm']);
        $confirm = $explode[0] . $transactionId . $explode[1];
        $body = $this->channelSecret . $confirm . json_encode($this->sendingData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encryption($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $confirm,
            json_encode($this->sendingData)
        );
    }

    /**
     * 捕獲
     */
    public function capture($transactionId)
    {
        DataChecker::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['capture']);
        $capture = $explode[0] . $transactionId . $explode[1];
        $body = $this->channelSecret . $capture . json_encode($this->sendingData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encryption($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $capture,
            json_encode($this->sendingData)
        );
    }

    /**
     * 無效處理
     */
    public function void($transactionId)
    {
        DataChecker::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['void']);
        $confirm = $explode[0] . $transactionId . $explode[1];
        $body = $this->channelSecret . $confirm . json_encode($this->sendingData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encryption($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $confirm,
            json_encode($this->sendingData)
        );
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        DataChecker::checkOrderNumber($this->sendingData['orderId'], 'orderId');
        $body = $this->channelSecret . $this->configs['paymentURLs']['search'] . http_build_query($this->sendingData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encryption($body)
        ])->get(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['search'],
            $this->sendingData
        );
    }

    /**
     * 退款
     */
    public function refund($transactionId = null)
    {
        DataChecker::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['refund']);
        $refund = $explode[0] . $transactionId . $explode[1];
        $body = $this->channelSecret . $refund . json_encode($this->sendingData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encryption($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $refund,
            json_encode($this->sendingData)
        );
    }
}
