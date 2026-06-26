<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

require './vendor/autoload.php';

use Zero\PaymentClient as PaymentClient;

// ECPay checkout example
$paymentClient = new PaymentClient('ec');
$payment = $paymentClient->createPayment();
$requests = [
  'MerchantID' => '2000132',
  'MerchantTradeNo' => date('YmdHis'),
  'MerchantTradeDate' => date('Y/m/d H:i:s'),
  'PaymentType' => 'aio',
  'TotalAmount' => 500,
  'TradeDesc' => urlencode('Test transaction'),
  'ItemName' => 'Demo product 500 TWD',
  'ReturnURL' => 'https://your.web.site/ecpay/return.php',
  'ChoosePayment' => 'Credit',
  'EncryptType' => 1,
];
// echo $payment->setRequestParameter($requests)->checkout();
// return;

// ECPay order search example
$requests = [
  'MerchantID' => '2000132',
  'MerchantTradeNo' => '220220811214215',
  'TimeStamp' => time(),
  'PlatformID' => 2000132,
];
// echo $payment->setRequestParameter($requests)->search();
// return;

// ECPay credit detail search example
$requests = [
  'MerchantID' => '2000132',
  'CreditRefundId' => 12095677,
  'CreditCheckCode' => 25938511,
  'CreditAmount' => 500,
];
// echo $payment->setRequestParameter($requests)->searchDetail();
// return;

// ECPay refund example
$requests = [
  'MerchantID' => '2000132',
  'MerchantTradeNo' => 'zero20220821101552',
  'TradeNo' => '2208211615567910',
  'Action' => 'R',
  'TotalAmount' => 100,
];
// echo $payment->setRequestParameter($requests)->refund();
// return;

// LINE Pay checkout example
$paymentClient = new PaymentClient('line');
$payment = $paymentClient->createPayment();
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
          'name' => 'Demo product',
          'imageUrl' => 'https://example.com/product.jpg',
          'quantity' => 1,
          'price' => 100,
        ],
      ],
    ],
  ],
  'redirectUrls' => [
    'confirmUrl' => 'https://your.web.site/line-pay/confirm.php',
    'cancelUrl' => 'https://your.web.site/line-pay/cancel.php',
  ],
];
// echo $payment->setRequestParameter($requests)->checkout();
// return;

// LINE Pay confirm example
$requests = [
  'amount' => 100,
  'currency' => 'TWD',
];
// echo $payment->setRequestParameter($requests)->confirm(2022082400725100210);
// return;

// LINE Pay order search example
$requests = [
  'orderId' => '20220821103746',
];
// echo $payment->setRequestParameter($requests)->search();
// return;

// LINE Pay refund example
$requests = [
  'refundAmount' => 100,
];
// echo $payment->setRequestParameter($requests)->refund(2022082400725100210);
// return;
