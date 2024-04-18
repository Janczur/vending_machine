<?php

namespace App\Tests\VendingMachine\Core\Domain\Remainder;

use App\VendingMachine\Core\Domain\Coin\CoinCollection;
use App\VendingMachine\Core\Domain\Product\Product;
use App\VendingMachine\Core\Domain\Remainder\RemainderCalculator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RemainderCalculatorTest extends TestCase
{
    public function testItCalculatesRemainder(): void
    {
        $coinCollection = $this->createMock(CoinCollection::class);
        $coinCollection->method('total')->willReturn(100);

        $product = $this->createMock(Product::class);
        $product->method('price')->willReturn(50);

        $remainder = RemainderCalculator::calculate($coinCollection, $product);

        self::assertEquals(50, $remainder->getValue());
    }

    public function testItThrowsExceptionWhenNotEnoughMoneyToBuyAProduct(): void
    {
        $coinCollection = $this->createMock(CoinCollection::class);
        $coinCollection->method('total')->willReturn(50);

        $product = $this->createMock(Product::class);
        $product->method('price')->willReturn(100);

        $this->expectException(InvalidArgumentException::class);
        RemainderCalculator::calculate($coinCollection, $product);
    }
}
