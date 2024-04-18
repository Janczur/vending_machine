<?php

namespace App\Tests\VendingMachine\Core\Domain\Remainder;

use App\VendingMachine\Core\Domain\Remainder\Remainder;
use App\VendingMachine\Core\Domain\Remainder\RemainderInCoinsCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RemainderInCoinsCalculatorTest extends TestCase
{
    public static function remainderProvider(): array
    {
        return [
            'basic case' => [54, [50, 2, 2]],
            'complex combination' => [99, [50, 20, 20, 5, 2, 2]],
            'single largest coin' => [100, [100]],
            'smallest amount' => [1, [1]],
            'no remainder' => [0, []],
            'no exact denomination match for some of the remainder' => [27, [20, 5, 2]],
            'mixed denominations with single units' => [128, [100, 20, 5, 2, 1]]
        ];
    }

    #[DataProvider('remainderProvider')]
    public function testCalculateCoinsBasedOnRemainder(int $remainder, array $expectedResult): void
    {
        $coins = RemainderInCoinsCalculator::calculate(
            Remainder::fromInt($remainder)
        );
        $this->assertEquals($expectedResult, $coins->toArray());
    }
}
