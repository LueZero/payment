<?php

namespace Zero\Payment\Parameters;

class LinePaymentRequestParameter
{
    public string $amount;

    public string $currency;
    
    public string $orderId;
    
    public array $packages;
    
    public array $redirectUrls;
    
    public string $refundAmount;

    public array $options;
}
