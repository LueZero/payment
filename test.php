<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require './vendor/autoload.php';

use Zero\Payment\PaymentClient as PaymentClient;

// 綠界 付款範例
$payment = new PaymentClient('ec');

$requests = [
  'MerchantID' => 2000132,
  'MerchantTradeNo' => 'zero' . date('YmdHis'),
  'MerchantTradeDate' => date('Y/m/d H:i:s'),
  'PaymentType' => 'aio',
  'TotalAmount' => 500,
  'TradeDesc' => urlencode('測試交易'),
  'ItemName' => '手機20元',
  'ReturnURL' => 'https://your.web.site/receive.php',
  'ChoosePayment' => 'Credit',
  'EncryptType' => 1,
  'awd' => 1,
];
//echo $payment->getPayment()->requestParameter($requests)->dataProcess()->checkouts();
//return;

// 綠界 搜尋範例
$requests = [
  'MerchantID' => 2000132,
  'MerchantTradeNo' => 'zero20220821101552',
  'TimeStamp' => time(),
  'PlatformID' => 2000132,
];
//echo $payment->getPayment()->requestParameter($requests)->dataProcess()->search();
//return;

// 綠界 退款範例
$requests = [
    'MerchantID' => 2000132,
    'MerchantTradeNo' => 'zero20220821101552',
    'TradeNo' => '2208211615567910',
    'Action' => 'R',
    'TotalAmount' => 100,
];
//echo $payment->getPayment()->requestParameter($requests)->dataProcess()->refund();
//return;

/*--------分隔線-----------*/

// Line 付款範例 
$payment = new PaymentClient('line');

$transactionId = date('YmdHis');
$requests = [
  'amount' => 100,
  'currency' => 'TWD',
  'orderId' =>  $transactionId,
  'packages' => [
    [
      'id' => 1,
      'amount' => 100,
      'name' => 'Test',
      'products' => [
        [
          'name' => '測試商品',
          'imageUrl' => 'https://img.ruten.com.tw/s1/8/5f/69/21309199705961_969_m.jpg',
          'quantity' => 1,
          'price' => 100,
        ]
      ],
    ]
  ],
  'redirectUrls' => [
    'confirmUrl' => 'https://your.web.site/receive.php',
    'cancelUrl' => 'https://your.web.site/receive.php'
  ]
];
// echo $payment->getPayment()->requestParameter($requests)->dataProcess()->checkouts();
// return;

// line 確認範例
$requests = [
  'amount' => 100,
  'currency' => 'TWD',
];
// echo $payment->getPayment()->requestParameter($requests)->dataProcess()->confirm($transactionId);
// return;

// Line 查詢範例
$orderId = '20220821103746';
$requests = [
  'orderId' => '20220821103746'
];
// echo $payment->getPayment()->requestParameter($requests)->dataProcess()->search();
// return;

// Line 退款範例 2020121500644803511
$requests = [
  'refundAmount' => 100
];
//echo $payment->getPayment()->requestParameter($requests)->dataProcess()->refund($transactionId);
// return;