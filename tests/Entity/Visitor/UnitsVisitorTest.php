<?php

namespace App\Tests\Entity\Visitor;

use App\Entity\Capacitor;
use App\Entity\Inductor;
use App\Entity\Resistor;
use App\Visitor\UnitsVisitor;
use PHPUnit\Framework\TestCase;

class UnitsVisitorTest extends TestCase
{

    public function testVisitCapacitor()
    {
        $visitor = new UnitsVisitor();
        self::assertSame('C', $visitor->visitCapacitor(new Capacitor()));

    }

    public function testVisitResistor()
    {
        $visitor = new UnitsVisitor();
        self::assertSame('Ω', $visitor->visitResistor(new Resistor()));
    }

    public function testVisitInductor()
    {
        $visitor = new UnitsVisitor();
        self::assertSame('H', $visitor->visitInductor(new Inductor()));
    }
}
