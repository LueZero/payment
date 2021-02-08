<?php

namespace Zero\Pay\PayMethod;

interface PayInterface 
{
    public function createOrder($orderData);
    public function dataProcess();
    public function checkOut();
    public function refund();
    public function searchOrder($requestsData);
    public function result();
}
