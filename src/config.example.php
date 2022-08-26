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
            'checkout' => '/Cashier/AioCheckOut/V5',
            'search' => '/Cashier/QueryTradeInfo/V5',
            'searchDetail' => '/CreditDetail/QueryTrade/V2',
            'refund' => '/CreditDetail/DoAction'
        ]
    ],
    'line' => [
        'paymentParameters' => [
            'ChannelId' => 1654180534,
            'ChannelSecret' => '0b493ba53c7ee3ed1f228bf00dfc9639',
        ],
        'paymentURLs' => [
            'baseURL' => 'https://sandbox-api-pay.line.me',
            'checkout' => '/v3/payments/request',
            'capture' => '/v3/payments/{}/capture',
            'confirm' => '/v3/payments/{}/confirm',
            'void' => '/v3/payments/{}/void',
            'search' => '/v3/payments',
            'refund' => '/v3/payments/{}/refund',
        ]
    ]
];
