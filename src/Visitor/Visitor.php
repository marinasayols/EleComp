<?php

namespace App\Visitor;

use App\Entity\Capacitor;
use App\Entity\Inductor;
use App\Entity\Resistor;

interface Visitor
{
    public function visitResistor(Resistor $component);

    public function visitCapacitor(Capacitor $component);

    public function visitInductor(Inductor $component);
}