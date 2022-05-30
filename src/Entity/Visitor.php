<?php

namespace App\Entity;

interface Visitor
{
    public function visitResistor(Resistor $component) : void;

    public function visitCapacitor(Capacitor $component) : void;

    public function visitInductor(Inductor $component) : void;
}