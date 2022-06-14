<?php

namespace App\Visitor;

use App\Entity\Capacitor;
use App\Entity\Inductor;
use App\Entity\Resistor;
use App\Form\CapacitorType;
use App\Form\ComponentType;
use App\Form\ResistorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

class CreateFormVisitor extends AbstractController implements Visitor
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
        echo "Inductor\n";
    }
}