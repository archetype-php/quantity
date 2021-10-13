<?php

declare(strict_types=1);

namespace Archetype\Quantity;

class Quantity
{
    private string $amount;

    private function __construct(string $amount)
    {
        $this->amount = $amount;
    }

    public static function fromString(string $amount): self
    {
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Invalid quantity amount, numeric string required.');
        }

        return new self($amount);
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function add(self $quantity): self
    {
        return new self(bcadd($this->amount, $quantity->amount));
    }

    public function subtract(self $quantity): self
    {
        return new self(bcsub($this->amount, $quantity->amount));
    }
}
