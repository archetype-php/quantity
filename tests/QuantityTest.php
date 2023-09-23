<?php

declare(strict_types=1);

namespace Archetype\Quantity\Tests;

use Archetype\Quantity\Quantity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Quantity::class)]
class QuantityTest extends TestCase
{
    #[DataProvider('numericStringProvider')]
    public function testQuantityNumericAmount(string $amount): void
    {
        self::assertSame($amount, Quantity::fromString($amount)->amount());
    }

    /**
     * @return iterable<array<string>>
     */
    public static function numericStringProvider(): iterable
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

    #[DataProvider('addProvider')]
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
    public static function addProvider(): iterable
    {
        yield 'integers' => ['0', '1', '1.00'];
        yield 'floats' => ['0.1', '0.2', '0.30'];
    }

    #[DataProvider('subtractProvider')]
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
    public static function subtractProvider(): iterable
    {
        yield 'integers' => ['5', '4', '1.00'];
        yield 'floats' => ['0.3', '0.2', '0.10'];
    }

    public function testScaleValidation(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Quantity::fromString('1', -1);
    }

    #[DataProvider('multiplicationProvider')]
    public function testMultiplication(string $base, string $multiplier, string $result): void
    {
        $base = Quantity::fromString($base);
        $product = $base->multiply(Quantity::fromString($multiplier));

        self::assertSame($result, $product->amount());
        self::assertNotSame($base, $product);
    }

    /**
     * @return iterable<array<string>>
     */
    public static function multiplicationProvider(): iterable
    {
        yield 'integers' => ['5', '4', '20.00'];
        yield 'one negative' => ['-5', '4', '-20.00'];
        yield 'two negatives' => ['-5', '-4', '20.00'];
        yield 'floats' => ['0.3', '0.2', '0.06'];
    }
}
