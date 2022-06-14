<?php

namespace App\Visitor;

use App\Entity\Capacitor;
use App\Entity\Inductor;
use App\Entity\Resistor;

class UnitsVisitor implements Visitor
{

    public function visitResistor(Resistor $component)
    {
        return 'Ω';
    }

    public function visitCapacitor(Capacitor $component)
    {
        return 'C';
    }

    public function visitInductor(Inductor $component)
    {
        return 'H';
    }
}