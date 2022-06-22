<?php

namespace App\Tests\Entity\Visitor;

use App\Entity\Capacitor;
use App\Entity\Inductor;
use App\Entity\Resistor;
use App\Visitor\CustomFieldsVisitor;
use PHPUnit\Framework\TestCase;

class CustomFieldsVisitorTest extends TestCase
{

    public function testVisitInductor()
    {
        $visitor = new CustomFieldsVisitor();
        self::assertSame([
            ['name' => 'maxCurrent', 'unit' => 'mA'],
            ['name' => 'DCResistance', 'unit' => 'mΩ']
        ], $visitor->visitInductor(new Inductor()));
    }

    public function testVisitResistor()
    {
        $visitor = new CustomFieldsVisitor();
        self::assertSame([
            ['name' => 'power', 'unit' => 'W'],
            ['name' => 'package', 'unit' => '']
        ], $visitor->visitResistor(new Resistor()));
    }

    public function testVisitCapacitor()
    {
        $visitor = new CustomFieldsVisitor();
        self::assertSame([
            ['name' => 'voltage', 'unit' => 'V'],
            ['name' => 'temperatureCoefficient', 'unit' => '']
        ], $visitor->visitCapacitor(new Capacitor()));
    }
}
