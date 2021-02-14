<?php

namespace Zero\Pay\PayMethod;

interface PayInterface 
{
    public function dataProcess();
    public function checkouts();
    public function refund();
    public function search();
}
