<?php
declare(strict_types=1);

namespace App\VendingMachine\Core\Domain\Coin;

use InvalidArgumentException;

final readonly class Coin
{
    public const ALLOWED_COINS = [1, 2, 5, 10, 20, 50, 100];

    private function __construct(
        private int $value
    ) {}

    public static function fromInt(int $amount): self
    {
        if (!in_array($amount, self::ALLOWED_COINS)) {
            throw new InvalidArgumentException(
                'Invalid coin amount given. Allowed values: ' . implode(
                    ', ',
                    self::ALLOWED_COINS
                ) . '. Given: ' . $amount . '.'
            );
        }

        return new self($amount);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}