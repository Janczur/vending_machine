<?php
declare(strict_types=1);

namespace App\VendingMachine\Core\Domain\Remainder;

use InvalidArgumentException;

final readonly class Remainder
{
    private function __construct(
        private int $value
    ) {}

    public static function fromInt(int $value): self
    {
        if ($value < 0) {
            throw new InvalidArgumentException(
                "Remainder must be a positive integer. Given: $value"
            );
        }
        return new self($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isZero(): bool
    {
        return $this->value === 0;
    }
}