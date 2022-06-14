<?php

namespace App\Visitor;

use App\Entity\Capacitor;
use App\Entity\Inductor;
use App\Entity\Resistor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomFieldsVisitor implements Visitor
{
    public function visitResistor(Resistor $component)
    {
        return [
            ['name' => 'power', 'unit' => 'W'],
            ['name' => 'package', 'unit' => '']
        ];
    }

    public function visitCapacitor(Capacitor $component)
    {
        return [
            ['name' => 'voltage', 'unit' => 'V'],
            ['name' => 'temperatureCoefficient', 'unit' => '']
        ];
    }

    public function visitInductor(Inductor $component)
    {
        return [
            ['name' => 'maxCurrent', 'unit' => 'mA'],
            ['name' => 'DCResistance', 'unit' => 'mΩ']
        ];
    }
}