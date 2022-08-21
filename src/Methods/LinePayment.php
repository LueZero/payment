<?php

namespace Zero\Payment\Methods;

use Zero\Payment\Http;
use Zero\Payment\Helpers\DataCheck;
use Zero\Payment\Parameters\LinePaymentRequestParameter;

class LinePayment extends Payment
{
    private LinePaymentRequestParameter $paymentRequestParameter;

    /**
     * 建構子
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
        $this->paymentRequestParameter = new LinePaymentRequestParameter();
    }

    /**
     * 取得請求參數
     */
    public function getRequestParameter()
    {
        return $this->paymentRequestParameter;
    }

    /**
     * 設定請求參數
     */
    public function setRequestParameter($requests): Payment
    {
        DataCheck::whetherEmpty($requests, 'Zero\Payment\Helpers\DataCheck::[requests data is empty]');

        foreach ($requests as $key => $item) {
            if (!isset($this->paymentRequestParameter->$key))
                $this->paymentRequestParameter->$key = $item;
        }

        return $this;
    }

    /**
     * 資料處理
     */
    public function dataProcess(): Payment
    {
        $this->sends = (array) $this->paymentRequestParameter;
        return $this;
    }

    /**
     * 加密
     */
    public function encrypt($data)
    {
        return base64_encode(hash_hmac('sha256', $data, $this->necessaryParameters['paymentParameters']['ChannelSecret'], true));
    }

    /**
     * 結帳
     */
    public function checkouts()
    {
        DataCheck::exhaustiveCheckSends($this->necessaryParameters, $this->sends, 'requestParameters');
        $body = $this->necessaryParameters['paymentParameters']['ChannelSecret'] . $this->necessaryParameters['paymentUrls']['checkoutUrl'] . json_encode($this->sends) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->necessaryParameters['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->necessaryParameters['paymentUrls']['lineApiUrl'] . $this->necessaryParameters['paymentUrls']['checkoutUrl'],
            json_encode($this->sends)
        );
    }

    /**
     * 確認
     */
    public function confirm($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explodeUrl = explode('{}', $this->necessaryParameters['paymentUrls']['confirmUrl']);
        $confirmUrl = $explodeUrl[0] . $transactionId . $explodeUrl[1];
        $body = $this->necessaryParameters['paymentParameters']['ChannelSecret'] . $confirmUrl . json_encode($this->sends) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->necessaryParameters['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->necessaryParameters['paymentUrls']['lineApiUrl'] . $confirmUrl,
            json_encode($this->sends)
        );
    }

    /**
     * 搜尋資料
     */
    public function search()
    {
        DataCheck::checkOrderNumber($this->sends['orderId'], 'orderId');
        $body = $this->necessaryParameters['paymentParameters']['ChannelSecret'] . $this->necessaryParameters['paymentUrls']['searchUrl'] . http_build_query($this->sends) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->necessaryParameters['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->get(
            $this->necessaryParameters['paymentUrls']['lineApiUrl'] . $this->necessaryParameters['paymentUrls']['searchUrl'],
            $this->sends
        );
    }

    /**
     * 退款
     */
    public function refund($transactionId)
    {
        DataCheck::checkOrderNumber($transactionId, 'transactionId');
        $explodeUrl = explode('{}', $this->necessaryParameters['paymentUrls']['refundUrl']);
        $refundUrl = $explodeUrl[0] . $transactionId . $explodeUrl[1];
        $body = $this->necessaryParameters['paymentParameters']['ChannelSecret'] . $refundUrl . json_encode($this->sends) . time();
        return $this->http->setup([
            'Content-Type: application/json',
            'X-LINE-ChannelId: ' . $this->necessaryParameters['paymentParameters']['ChannelId'],
            'X-LINE-Authorization-Nonce: ' . time(),
            'X-LINE-Authorization: ' . $this->encrypt($body)
        ])->post(
            $this->necessaryParameters['paymentUrls']['lineApiUrl'] . $refundUrl,
            json_encode($this->sends)
        );
    }
}
