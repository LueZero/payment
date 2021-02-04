<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class OrderTest extends TestCase
{
  public function testEmpty(): array
  {
    $stack = [];
    $this->assertEmpty($stack);
    return $stack;
  }

  /**
   * @depends testEmpty
   */
  public function testPush(array $stack): array
  {
    array_push($stack, 'foo');
    print_r($stack);
    $this->assertSame('foo', $stack[count($stack) - 1]);
    $this->assertNotEmpty($stack);
    return $stack;
  }

  /**
   * @depends testPush
   */
  public function testPop(array $stack): void
  {
    print_r($stack);
    $this->assertSame('foo', array_pop($stack));
    $this->assertEmpty($stack);
  }
}
