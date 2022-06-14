<?php

namespace App\Entity;

class ComponentComparator
{
    public static function compareName(Component $a, Component $b): int
    {
        return $a->getName() <=> $b->getName();
    }

    public static function compareValue(Component $a, Component $b): int
    {
        $converter = new ValueConverter();
        $a_val = $converter->getValue($a->getValue());
        $b_val = $converter->getValue($b->getValue());
        return $a_val <=> $b_val;
    }

    public static function compareTolerance(Component $a, Component $b): int
    {
        return $a->getTolerance() <=> $b->getTolerance();
    }

    public static function comparePrice(Component $a, Component $b): int
    {
        return floatval($a->getPrice()) <=> floatval($b->getPrice());
    }

    public static function comparePower(Resistor $a, Resistor $b): int
    {
        return floatval($a->getPower()) <=> floatval($b->getPower());
    }

    public static function comparePackage(Resistor $a, Resistor $b): int
    {
        return $a->getPackage() <=> $b->getPackage();
    }

    public static function compareVoltage(Capacitor $a, Capacitor $b): int
    {
        return floatval($a->getVoltage()) <=> floatval($b->getVoltage());
    }

    public static function compareTemperatureCoefficient(Capacitor $a, Capacitor $b): int
    {
        return $a->getTemperatureCoefficient() <=> $b->getTemperatureCoefficient();
    }

    public static function compareMaxCurrent(Inductor $a, Inductor $b): int
    {
        return floatval($a->getMaxCurrent()) <=> floatval($b->getDCResistance());
    }

    public static function compareDCResistance(Inductor $a, Inductor $b): int
    {
        return floatval($a->getDCResistance()) <=> floatval($b->getDCResistance());
    }

}