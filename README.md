## 整合第三方金流服務

- [綠界科技](https://www.ecpay.com.tw/)
- [Line金流](https://pay.line.me/portal/tw/main)

## 付款使用方式

```php
require './vendor/autoload.php';

use Zero\Payment\PayClient as PayClient;
```

```php
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
];
echo $payment->getPayment()->requestParameter($requests)->dataProcess()->checkouts();

// 綠界 搜尋範例
$requests = [
  'MerchantID' => 2000132,
  'MerchantTradeNo' => 'xxxxx',
  'TimeStamp' => time(),
  'PlatformID' => 2000132,
];
echo $payment->getPayment()->requestParameter($requests)->dataProcess()->search();

// 綠界 退款範例
$requests = [
    'MerchantID' => 2000132,
    'MerchantTradeNo' => 'xxx',
    'TradeNo' => 'xxx',
    'Action' => 'R',
    'TotalAmount' => 100,
];
echo $payment->getPayment()->requestParameter($requests)->dataProcess()->refund();
```

```php
// Line 付款範例 
$payment = new PaymentClient('line');

$orderId = 'zero' . date('YmdHis');
$requests = [
  'amount' => 100,
  'currency' => 'TWD',
  'orderId' =>  $orderId,
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
echo $payment->getPayment()->requestParameter($requests)->dataProcess()->checkouts();

// line 確認範例
$orderId = $orderId;
$requests = [
  'amount' => 100,
  'currency' => 'TWD',
];
echo $payment->getPayment()->requestParameter($requests)->dataProcess()->confirm($orderId);

// Line 查詢範例
$requests = [
  'orderId' => $orderId
];
echo $payment->getPayment()->requestParameter($requests)->dataProcess()->search();

// Line 退款範例 2020121500644803511
$orderId = 2020121500644803511;
$requests = [
  'refundAmount' => 100
];
echo $payment->getPayment()->requestParameter($requests)->dataProcess()->refund($orderId);
```

## 測試使用指令
```zsh
./vendor/bin/phpunit tests
```