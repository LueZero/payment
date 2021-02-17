<?php

namespace Zero\Pay\PayMethod;

interface PayInterface
{
    public function dataProcess();
    public function checkouts();
    public function refund($orderId);
    public function search();
    public function selectNecessaryParametersConfig($pay);
    public function requestParameter($data);
}
