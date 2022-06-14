<?php

namespace App\Tests\Entity;

use App\Entity\ValueConverter;
use PHPUnit\Framework\TestCase;

class ValueConverterTest extends TestCase
{
    public function testGetValueWithPrefix()
    {
        $converter = new ValueConverter();
        $s_value = "10n8";
        $this->assertSame(1.08E-8, $converter->getValue($s_value));
    }

    public function testGetValueWithDecimalPoint()
    {
        $converter = new ValueConverter();
        $s_value = "1.5";
        $this->assertSame(1.5, $converter->getValue($s_value));
    }

    public function testGetValueInteger()
    {
        $converter = new ValueConverter();
        $s_value = "10";
        $this->assertSame(10.0, $converter->getValue($s_value));
    }

    public function testGetValueNotANumberError()
    {
        $this->expectException(\InvalidArgumentException::class);
        $converter = new ValueConverter();
        $s_value = "hello";
        $converter->getValue($s_value);
    }
}
