<?php

namespace Zero\Payments;

use Zero\Http;
use Zero\Helpers\DataChecker;

class LINEPayment extends Payment
{
    /**
     * @var string
     */
    public $channelId;

    /**
     * @var string
     */
    public $channelSecret;

    /**
     * 建構子
     * @param Http http
     */
    public function __construct(Http $http)
    {
        parent::__construct();
        $this->http = $http;
        $this->requireConfig('line');
     
    }

    /**
     * @param array configs
     */
    public function setConfig($configs)
    {
        $this->configs = $configs;
        $this->channelId = empty($this->configs['paymentParameters']['ChannelId']) == true ? null : $this->configs['paymentParameters']['ChannelId'];
        $this->channelSecret = empty($this->configs['paymentParameters']['ChannelSecret']) == true ? null : $this->configs['paymentParameters']['ChannelSecret'];
    }

    /**
     * 加密
     * @param array data
     * @return string
     */
    public function encrypt($data)
    {
        return base64_encode(hash_hmac('sha256', $data, $this->channelSecret, true));
    }

    /**
     * 結帳
     * @return string 
     */
    public function checkout()
    {
        $body = $this->channelSecret . $this->configs['paymentURLs']['checkout'] . json_encode($this->sendData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['checkout'],
            json_encode($this->sendData)
        );
    }

    /**
     * 確認
     * @param string transactionId
     * @return string
     */
    public function confirm($transactionId)
    {
        DataChecker::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['confirm']);
        $confirm = $explode[0] . $transactionId . $explode[1];
        $body = $this->channelSecret . $confirm . json_encode($this->sendData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $confirm,
            json_encode($this->sendData)
        );
    }

    /**
     * 捕獲
     * @param string transactionId
     * @return string
     */
    public function capture($transactionId)
    {
        DataChecker::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['capture']);
        $capture = $explode[0] . $transactionId . $explode[1];
        $body = $this->channelSecret . $capture . json_encode($this->sendData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $capture,
            json_encode($this->sendData)
        );
    }

    /**
     * 無效處理
     * @param string transactionId
     * @return string
     */
    public function void($transactionId)
    {
        DataChecker::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['void']);
        $confirm = $explode[0] . $transactionId . $explode[1];
        $body = $this->channelSecret . $confirm . json_encode($this->sendData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $confirm,
            json_encode($this->sendData)
        );
    }

    /**
     * 搜尋資料
     * @return string  
     */
    public function search()
    {
        DataChecker::checkOrderNumber($this->sendData['orderId'], 'orderId');
        $body = $this->channelSecret . $this->configs['paymentURLs']['search'] . http_build_query($this->sendData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->get(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['search'],
            $this->sendData
        );
    }

    /**
     * 退款
     * @param string transactionId
     * @return string 
     */
    public function refund($transactionId = null)
    {
        DataChecker::checkOrderNumber($transactionId, 'transactionId');
        $explode = explode('{}', $this->configs['paymentURLs']['refund']);
        $refund = $explode[0] . $transactionId . $explode[1];
        $body = $this->channelSecret . $refund . json_encode($this->sendData) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $refund,
            json_encode($this->sendData)
        );
    }
}
