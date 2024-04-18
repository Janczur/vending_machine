<?php
declare(strict_types=1);

namespace App\VendingMachine\Core\Domain\Remainder;

use App\VendingMachine\Core\Domain\Coin\CoinCollection;
use App\VendingMachine\Core\Domain\Product\Product;
use InvalidArgumentException;

class RemainderCalculator
{
    public static function calculate(CoinCollection $coinCollection, Product $product): Remainder
    {
        if ($coinCollection->total() < $product->price()) {
            throw new InvalidArgumentException(
                'Not enough money to buy the product. You have ' . $coinCollection->total(
                ) . ' cents and the product costs ' . $product->price() . ' cents. Please insert more coins.'
            );
        }
        $remainder = $coinCollection->total() - $product->price();
        return Remainder::fromInt($remainder);
    }
}