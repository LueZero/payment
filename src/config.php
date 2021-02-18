<?php

return [
    "ecpay" => [
        "MerchantID" => 2000132,
        "HashKey" => "5294y06JbISpM5x9",
        "HashIV" => "v77hoKGq4kWxNNIS",
        "ecPayApiUrl" => "https://payment-stage.ecpay.com.tw",
        "checkoutUrl" => "/Cashier/AioCheckOut/V5",
        "searchUrl" => "/Cashier/QueryTradeInfo/V5",
        "searchDetailsUrl" => "/CreditDetail/QueryTrade/V2",
        "refundUrl" => "/CreditDetail/DoAction",
        "checkoutParameter" => [
            "MerchantID",
            "MerchantTradeNo",
            "MerchantTradeDate",
            "PaymentType",
            "TotalAmount",
            "TradeDesc",
            "ItemName",
            "ReturnURL",
            "ChoosePayment",
            "EncryptType",
        ]
    ],

    "linepay" => [
        "ChannelId" => "1654180534",
        "lineApiUrl" => "https://sandbox-api-pay.line.me",
        "ChannelSecret" => "0b493ba53c7ee3ed1f228bf00dfc9639",
        "checkoutUrl" => "/v3/payments/request",
        "confirmUrl" => "/v3/payments/{}/confirm",
        "searchUrl" => "/v3/payments",
        "refundUrl" => "/v3/payments/{}/refund",
        "checkoutParameter" => [
            "amount",
            "currency",
            "orderId",
            "packages",
            'redirectUrls'
        ]
    ]
];
