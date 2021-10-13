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

    public function testQuantityInvalidNumericAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Quantity::fromString('hello');
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd(string $base, string $addend, string $result): void
    {
        $base = Quantity::fromString($base);
        $sum = $base->add(Quantity::fromString($addend));

        self::assertSame($result, $sum->amount());
        self::assertNotSame($base, $sum);
    }

    /**
     * @return iterable<array<string>>
     */
    public function addProvider(): iterable
    {
        yield 'integers' => ['0', '1', '1'];
    }

    /**
     * @dataProvider subtractProvider
     */
    public function testSubtract(string $base, string $subtrahend, string $result): void
    {
        $base = Quantity::fromString($base);
        $difference = $base->subtract(Quantity::fromString($subtrahend));

        self::assertSame($result, $difference->amount());
        self::assertNotSame($base, $difference);
    }

    /**
     * @return iterable<array<string>>
     */
    public function subtractProvider(): iterable
    {
        yield 'integers' => ['5', '4', '1'];
    }
}
