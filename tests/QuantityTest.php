<?php

declare(strict_types=1);

namespace Archetype\Quantity\Tests;

use Archetype\Quantity\Quantity;
use PHPUnit\Framework\TestCase;

class QuantityTest extends TestCase
{
    /**
     * @dataProvider numericStringProvider
     */
    public function testQuantityNumericAmount(string $amount): void
    {
        self::assertSame($amount, Quantity::fromString($amount)->amount());
    }

    /**
     * @return iterable<array<string>>
     */
    public function numericStringProvider(): iterable
    {
        yield 'integer' => ['123'];
        yield 'float' => ['123.99'];
        yield 'decimal float' => ['.99'];
        yield 'exponent' => ['-1.3e3'];
    }
}
