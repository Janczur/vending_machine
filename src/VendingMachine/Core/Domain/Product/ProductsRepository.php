<?php
declare(strict_types=1);

namespace App\VendingMachine\Core\Domain\Product;

class ProductsRepository
{
    private array $products;

    public function __construct()
    {
        $this->products = [
            new Product('A', 95),
            new Product('B', 126),
            new Product('C', 233),
        ];
    }

    public function findProductByCode(string $code): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->code() === $code) {
                return $product;
            }
        }

        return null;
    }
}