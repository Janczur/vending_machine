<?php
declare(strict_types=1);

namespace App\VendingMachine\Core\ModuleApi;

use App\VendingMachine\Core\Domain\Coin\CoinCollection;
use App\VendingMachine\Core\Domain\Product\ProductsRepository;
use App\VendingMachine\Core\Domain\Remainder\RemainderCalculator;
use App\VendingMachine\Core\Domain\Remainder\RemainderInCoinsCalculator;
use LogicException;

final class VendingMachine
{
    public function __construct(
        private readonly ProductsRepository $repository
    ) {}

    /**
     * It tries to buy a product with the given amount of coins.
     * Then, it returns the remainder in coins.
     *
     * @param array $coins
     * @param string $productCode
     * @return array
     */
    public function buyProduct(array $coins, string $productCode): array
    {
        if (!$product = $this->repository->findProductByCode($productCode)) {
            throw new LogicException("Product with code $productCode not found");
        }
        $coinCollection = CoinCollection::fromArray($coins);

        $remainder = RemainderCalculator::calculate($coinCollection, $product);

        $remainderInCoins = RemainderInCoinsCalculator::calculate($remainder);

        return $remainderInCoins->toArray();
    }
}