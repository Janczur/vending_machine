<?php
declare(strict_types=1);

namespace App\VendingMachine\Core\Domain\Coin;

class CoinCollection
{
    private function __construct(
        private readonly array $coins
    ) {}

    public static function fromArray(array $coins): self
    {
        return self::create(
            ...array_map(
                static fn(int $coin) => Coin::fromInt($coin),
                $coins
            )
        );
    }

    public static function create(Coin ...$coins): self
    {
        return new self($coins);
    }

    public function total(): int
    {
        return array_reduce(
            $this->coins,
            static fn(int $total, Coin $coin) => $total + $coin->getValue(),
            0
        );
    }

    public function toArray(): array
    {
        return array_map(
            static fn(Coin $coin) => $coin->getValue(),
            $this->coins
        );
    }
}