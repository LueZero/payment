<?php

namespace Zero\Pay\PayMethod;

interface PayInterface
{
    public function encrypt($data);
    public function dataProcess();
    public function checkouts();
    public function refund($orderId);
    public function search();
    public function requestParameter($data);
}
