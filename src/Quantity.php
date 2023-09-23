<?php

declare(strict_types=1);

namespace Archetype\Quantity;

class Quantity
{
    private string $amount;
    private int $scale;

    private function __construct(string $amount, int $scale)
    {
        $this->amount = $amount;
        $this->scale = $scale;
    }

    public static function fromString(string $amount, int $scale = 2): self
    {
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Invalid quantity amount, numeric string required');
        }
        if ($scale < 0) {
            throw new \InvalidArgumentException('Scale must be equal or higher than zero');
        }

        return new self($amount, $scale);
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function add(self $quantity): self
    {
        return new self(bcadd($this->amount, $quantity->amount, $this->scale), $this->scale);
    }

    public function subtract(self $quantity): self
    {
        return new self(bcsub($this->amount, $quantity->amount, $this->scale), $this->scale);
    }

    public function multiply(self $quantity): self
    {
        return new self(bcmul($this->amount, $quantity->amount, $this->scale), $this->scale);
    }
}
