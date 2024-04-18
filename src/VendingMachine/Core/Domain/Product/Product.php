<?php
declare(strict_types=1);

namespace App\VendingMachine\Core\Domain\Product;

class Product
{
    private string $code;
    private int $price;

    public function __construct(string $code, int $price)
    {
        $this->code = $code;
        $this->price = $price;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function price(): int
    {
        return $this->price;
    }
}