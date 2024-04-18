<?php

namespace App\Tests\VendingMachine\Core\ModuleApi;

use App\VendingMachine\Core\Domain\Product\Product;
use App\VendingMachine\Core\Domain\Product\ProductsRepository;
use App\VendingMachine\Core\ModuleApi\VendingMachine;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TypeError;

class VendingMachineTest extends TestCase
{
    private ProductsRepository $productsRepository;
    private VendingMachine $vendingMachine;

    public static function productPurchaseProvider(): array
    {
        return [
            'no remaining' => [
                'coins' => [100],
                'productPrice' => 100,
                'expectedRemainingCoins' => []
            ],
            'requires remaining' => [
                'coins' => [100, 20, 10],
                'productPrice' => 95,
                'expectedRemainingCoins' => [20, 10, 5]
            ],
            'multiple small coins' => [
                'coins' => [10, 10, 10, 10, 5, 10, 10, 100, 10, 10],
                'productPrice' => 95,
                'expectedRemainingCoins' => [50, 20, 20]
            ],
            'more than required' => [
                'coins' => [100, 100, 100],
                'productPrice' => 250,
                'expectedRemainingCoins' => [50]
            ],
            'small coins insufficient' => [
                'coins' => [1, 1, 1, 1, 1],
                'productPrice' => 5,
                'expectedRemainingCoins' => []
            ],
            'large amount with change' => [
                'coins' => [100, 100, 100, 50],
                'productPrice' => 315,
                'expectedRemainingCoins' => [20, 10, 5]
            ]
        ];
    }

    #[DataProvider('productPurchaseProvider')] public function testBuyProductWithCoins(
        array $coins,
        int $productPrice,
        array $expectedRemainingCoins
    ): void
    {
        $product = $this->createMock(Product::class);
        $product->method('price')->willReturn($productPrice);
        $this->productsRepository->method('findProductByCode')->willReturn($product);

        $remainingInCoins = $this->vendingMachine->buyProduct($coins, 'test');

        $this->assertEquals($expectedRemainingCoins, $remainingInCoins);
    }

    public function testItThrowsExceptionIfProductIsNotFound(): void
    {
        $this->productsRepository->method('findProductByCode')->willReturn(null);

        $this->expectException(LogicException::class);
        $this->vendingMachine->buyProduct([1, 2], 'A');
    }

    public function testItThrowsExceptionIfNotEnoughMoney(): void
    {
        $productCode = 'A';
        $productPrice = 95;
        $product = $this->createMock(Product::class);
        $product->method('price')->willReturn($productPrice);
        $this->productsRepository->method('findProductByCode')->willReturn($product);

        $this->expectException(LogicException::class);
        $this->vendingMachine->buyProduct([1, 2], $productCode);
    }

    public function testItThrowsExceptionIfProvidedCoinsAreNotNumeric(): void
    {
        $productPrice = 95;
        $product = $this->createMock(Product::class);
        $product->method('price')->willReturn($productPrice);
        $this->productsRepository->method('findProductByCode')->willReturn($product);

        $this->expectException(TypeError::class);
        $this->vendingMachine->buyProduct(['a', 'b'], 'A');
    }

    public function setUp(): void
    {
        $this->productsRepository = $this->createMock(ProductsRepository::class);
        $this->vendingMachine = new VendingMachine($this->productsRepository);
    }
}
