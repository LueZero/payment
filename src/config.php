<?php

return [
    'ec' => [
        'paymentParameters' => [
            'MerchantID' => 2000132,
            'CreditCheckCode' => 25938511,
            'HashKey' => '5294y06JbISpM5x9',
            'HashIV' => 'v77hoKGq4kWxNNIS'
        ],
        'paymentUrls' => [
            'ecApiUrl' => 'https://payment-stage.ecpay.com.tw',
            'checkoutUrl' => '/Cashier/AioCheckOut/V5',
            'searchUrl' => '/Cashier/QueryTradeInfo/V5',
            'searchDetailsUrl' => '/CreditDetail/QueryTrade/V2',
            'refundUrl' => '/CreditDetail/DoAction'
        ]
    ],
    'line' => [
        'paymentParameters' => [
            'ChannelId' => 1654180534,
            'ChannelSecret' => '0b493ba53c7ee3ed1f228bf00dfc9639',
        ],
        'paymentUrls' => [
            'lineApiUrl' => 'https://sandbox-api-pay.line.me',
            'checkoutUrl' => '/v3/payments/request',
            'captureUrl' => '/v3/payments/{}/capture',
            'confirmUrl' => '/v3/payments/{}/confirm',
            'voidUrl' => '/v3/payments/{}/void',
            'searchUrl' => '/v3/payments',
            'refundUrl' => '/v3/payments/{}/refund',
        ]
    ]
];
