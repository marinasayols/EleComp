<?php

namespace App\Tests\Entity;

use App\Entity\Component;
use App\Entity\Resistor;
use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase
{
    public function testCompareValue()
    {
        $r1 = new Resistor();
        $r1->setValue("1m");
        $r2 = new Resistor();
        $r2->setValue("2n2");
        $r3 = new Resistor();
        $r3->setValue("2n2");
        $this->assertSame(1, Component::compareValue($r1, $r2));
        $this->assertSame(-1, Component::compareValue($r2, $r1));
        $this->assertSame(0, Component::compareValue($r2, $r3));
    }
}
