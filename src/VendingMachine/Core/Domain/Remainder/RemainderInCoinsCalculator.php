<?php
declare(strict_types=1);

namespace App\VendingMachine\Core\Domain\Remainder;

use App\VendingMachine\Core\Domain\Coin\Coin;
use App\VendingMachine\Core\Domain\Coin\CoinCollection;

class RemainderInCoinsCalculator
{
    public static function calculate(Remainder $remainder): CoinCollection
    {
        $remainderValue = $remainder->getValue();
        $allowedCoins = Coin::ALLOWED_COINS;
        rsort($allowedCoins);

        $coinsToReturn = [];

        foreach ($allowedCoins as $allowedCoin) {
            while ($remainderValue >= $allowedCoin) {
                $coinsToReturn[] = Coin::fromInt($allowedCoin);
                $remainderValue -= $allowedCoin;
            }
        }

        return CoinCollection::create(...$coinsToReturn);
    }
}