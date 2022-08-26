# 整合第三方金流服務

- [綠界科技](https://www.ecpay.com.tw/)
- [Line金流](https://pay.line.me/portal/tw/main)

# 金鑰設定

請複製/src/config.example.php更改為config.php即可使用(`預設內容為測試環境`)。

## 付款使用方式

```php
require './vendor/autoload.php';

use Zero\PayClient as PayClient;
```

```php
// 綠界 付款範例
$payment = new PaymentClient('ec');

$requests = [
  'MerchantID' => '2000132',
  'MerchantTradeNo' => 'zero' . date('YmdHis'),
  'MerchantTradeDate' => date('Y/m/d H:i:s'),
  'PaymentType' => 'aio',
  'TotalAmount' => 500,
  'TradeDesc' => urlencode('測試交易'),
  'ItemName' => '手機20元',
  'ReturnURL' => 'https://your.web.site/receive.php',
  'ChoosePayment' => 'Credit',
  'EncryptType' => 1,
];
// echo $payment->setRequestParameters($requests)->checkouts();
// return;

// 綠界 搜尋範例
$requests = [
  'MerchantID' => '2000132',
  'MerchantTradeNo' => 'zero20220821101552',
  'TimeStamp' => time(),
  'PlatformID' => 2000132,
];
// echo $payment->setRequestParameters($requests)->search();
// return;

// 綠界 搜尋明細範例
$requests = [
  'MerchantID' => '2000132',
  'CreditRefundId' => 12095677,
  'CreditCheckCode' => 25938511,
  'CreditAmount' => 500,
];
// echo $payment->setRequestParameters($requests)->searchDetail();
// return;

// 綠界 退款範例
$requests = [
    'MerchantID' => '2000132',
    'MerchantTradeNo' => 'zero20220821101552',
    'TradeNo' => '2208211615567910',
    'Action' => 'R',
    'TotalAmount' => 100,
];
// echo $payment->setRequestParameters($requests)->refund();
// return;

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
// echo $payment->setRequestParameters($requests)->checkouts();
// return;

// line 確認範例
$requests = [
  'amount' => 100,
  'currency' => 'TWD',
];
// echo $payment->setRequestParameters($requests)->confirm(2022082400725100210);
// return;

// Line 查詢範例
$requests = [
  'orderId' => '20220821103746'
];
// echo $payment->setRequestParameters($requests)->search();
// return;

// Line 退款範例
$requests = [
  'refundAmount' => 100
];
// echo $payment->setRequestParameters($requests)->refund(2022082400725100210);
// return;
```

## 測試使用指令
```zsh
./vendor/bin/phpunit tests
```