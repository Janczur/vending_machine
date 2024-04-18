<?php
declare(strict_types=1);

namespace App\Tests\VendingMachine\Core\Domain\Coin;

use App\VendingMachine\Core\Domain\Coin\Coin;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CoinTest extends TestCase
{
    public static function provideValidCoinValues(): array
    {
        return [
            [1],
            [2],
            [5],
            [10],
            [20],
            [50],
            [100],
        ];
    }

    #[DataProvider('provideValidCoinValues')]
    public function testItCreatesCoin(int $value): void
    {
        $coin = Coin::fromInt($value);

        self::assertEquals($value, $coin->getValue());
    }

    public function testItThrowsExceptionWhenCreatingCoinWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Coin::fromInt(3);
    }
}