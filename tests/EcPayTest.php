<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Zero\Pay\Pay as Pay;

final class EcPayTest extends TestCase
{
    public function testSetPay(): void
    {
        $pay = Pay::setPay("ecPay");
        $this->assertStringStartsWith('Zero\Pay\PayMethod\EcPay', get_class($pay));
    }
}