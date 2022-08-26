<?php

return [
    'ec' => [
        'paymentParameters' => [
            'MerchantID' => 2000132,
            'CreditCheckCode' => 25938511,
            'HashKey' => '5294y06JbISpM5x9',
            'HashIV' => 'v77hoKGq4kWxNNIS'
        ],
        'paymentURLs' => [
            'baseURL' => 'https://payment-stage.ecpay.com.tw',
            'checkoutURL' => '/Cashier/AioCheckOut/V5',
            'searchURL' => '/Cashier/QueryTradeInfo/V5',
            'searchDetailsURL' => '/CreditDetail/QueryTrade/V2',
            'refundURL' => '/CreditDetail/DoAction'
        ]
    ],
    'line' => [
        'paymentParameters' => [
            'ChannelId' => 1654180534,
            'ChannelSecret' => '0b493ba53c7ee3ed1f228bf00dfc9639',
        ],
        'paymentURLs' => [
            'baseURL' => 'https://sandbox-api-pay.line.me',
            'checkoutURL' => '/v3/payments/request',
            'captureURL' => '/v3/payments/{}/capture',
            'confirmURL' => '/v3/payments/{}/confirm',
            'voidURL' => '/v3/payments/{}/void',
            'searchURL' => '/v3/payments',
            'refundURL' => '/v3/payments/{}/refund',
        ]
    ]
];
