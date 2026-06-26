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
        $nonce = time();
        $postFields = json_encode($this->sendData);
        $body = $this->channelSecret . $this->configs['paymentURLs']['checkout'] . $postFields . $nonce;
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . $nonce,
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $this->configs['paymentURLs']['checkout'],
            $postFields
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
        $nonce = time();
        $postFields = json_encode($this->sendData);
        $body = $this->channelSecret . $confirm . $postFields . $nonce;
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . $nonce,
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $confirm,
            $postFields
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
        $nonce = time();
        $postFields = json_encode($this->sendData);
        $body = $this->channelSecret . $capture . $postFields . $nonce;
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . $nonce,
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $capture,
            $postFields
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
        $nonce = time();
        $postFields = json_encode($this->sendData);
        $body = $this->channelSecret . $confirm . $postFields . $nonce;
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . $nonce,
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $confirm,
            $postFields
        );
    }

    /**
     * 搜尋資料
     * @return string  
     */
    public function search()
    {
        DataChecker::checkOrderNumber($this->sendData['orderId'], 'orderId');
        $nonce = time();
        $body = $this->channelSecret . $this->configs['paymentURLs']['search'] . http_build_query($this->sendData) . $nonce;
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . $nonce,
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
        $nonce = time();
        $postFields = json_encode($this->sendData);
        $body = $this->channelSecret . $refund . $postFields . $nonce;
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->channelId,
            'X-LINE-Authorization-Nonce: ' . $nonce,
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->configs['paymentURLs']['baseURL'] . $refund,
            $postFields
        );
    }
}
