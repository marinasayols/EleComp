<?php

namespace App\Visitor;

use App\Entity\Capacitor;
use App\Entity\Inductor;
use App\Entity\Resistor;
use App\Form\CapacitorType;
use App\Form\InductorType;
use App\Form\ResistorType;

class CreateFormVisitor implements Visitor
{
    public function visitResistor(Resistor $component)
    {
        return ResistorType::class;
    }

    public function visitCapacitor(Capacitor $component)
    {
        return CapacitorType::class;
    }

    public function visitInductor(Inductor $component)
    {
        return InductorType::class;
    }
}