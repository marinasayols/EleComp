<?php

namespace App\Entity;

class ComponentVisitor implements Visitor
{
    public function visitResistor(Resistor $element): void
    {
        echo "Resistor\n";
    }

    public function visitCapacitor(Capacitor $component): void
    {
        echo "Capacitor\n";
    }

    public function visitInductor(Inductor $component): void
    {
        echo "Inductor\n";
    }
}