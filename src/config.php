<?php

return [
    "ecpay" => [
        "MerchantID" => 2000132,
        "HashKey" => "5294y06JbISpM5x9",
        "HashIV" => "v77hoKGq4kWxNNIS",
        "checkoutUrl" => "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5",
        "searchUrl" => "https://payment.ecpay.com.tw/Cashier/QueryTradeInfo/V5",
    ],

    "linepay" => [
        "ChannelId" => "1654180534",
        "lineApiUrl" => "https://sandbox-api-pay.line.me",
        "ChannelSecret" => "0b493ba53c7ee3ed1f228bf00dfc9639",
        "checkoutUrl" => "/v3/payments/request",
        "searchUrl" => "/v3/payments"
    ]
];
